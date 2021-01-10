<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 2007-2019 PayPal
 *  @author 2007-2013 PrestaShop SA <contact@prestashop.com>
 *  @author 2014-2019 202 ecommerce <tech@202-ecommerce.com>
 *  @copyright PayPal
 *  @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *  @version  Release: $Revision: 13573 $
 *
 */

include_once(_PS_MODULE_DIR_.'paypal/classes/Braintree.php');
include_once(_PS_MODULE_DIR_.'paypal/paypal.php');

class PayPalBraintreeSubmitModuleFrontController extends ModuleFrontController
{


    public function __construct()
    {
        parent::__construct();
        $this->ssl = true;

        if (class_exists('Context')) {
            $this->context = Context::getContext();
        } else {
            global $smarty, $cookie;
            $this->context = new StdClass();
            $this->context->smarty = $smarty;
            $this->context->cookie = $cookie;
        }
    }

    public function postProcess()
    {
        if (Tools::getValue('action') == 'getOrderInformation') {
            return $this->getOrderInformation();
        }

        $paypal = new PayPal();
        $braintree = new PrestaBraintree();
        $id_account_braintree = $paypal->set_good_context();

        if (empty($this->context->cart->id)) {
            $paypal->reset_context();
            $this->redirectFailedPayment($paypal->l('failed load cart'));
        }

        if (Tools::getValue('liabilityShifted') == 'false' && Tools::getValue('liabilityShiftPossible') == 'false') {
            $paypal->reset_context();
            $this->redirectFailedPayment($paypal->l('Authentication missing for this transaction.'));
        }

        if (Tools::getValue('liabilityShifted') == 'false' && Tools::getValue('liabilityShiftPossible') == 'true') {
            $paypal->reset_context();
            $this->redirectFailedPayment($paypal->l('Authentication unsuccessful for this transaction. Please try another card or payment method.'));
        }

        $cart_status = $braintree->cartStatus($this->context->cart->id);
        switch ($cart_status) {
            case 'alreadyUse':
                $order_id = Order::getOrderByCartId($this->context->cart->id);
                $this->redirectConfirmation($paypal->id, $this->context->cart->id, $order_id);
                break;
            case 'alreadyTry':
                $braintree_transaction = $braintree->checkStatus($this->context->cart->id);
                if ($braintree_transaction instanceof Braintree_Transaction && $braintree->isValidStatus($braintree_transaction->status)) {
                    $transactionDetail = $this->getDetailsTransaction($braintree_transaction->id, $braintree_transaction->status);
                    $paypal->validateOrder($this->context->cart->id, (Configuration::get('PAYPAL_CAPTURE')?Configuration::get('PAYPAL_BRAINTREE_OS_AWAITING'):Configuration::get('PS_OS_PAYMENT')), $braintree_transaction->amount, 'Braintree', $paypal->l('Payment accepted.'), $transactionDetail, $this->context->cart->id_currency, false, $this->context->customer->secure_key);
                    $order_id = Order::getOrderByCartId($this->context->cart->id);
                    $this->redirectConfirmation($paypal->id, $this->context->cart->id, $order_id);
                } else {
                    $this->redirectFailedPayment($paypal->l('Authentication unsuccessful for this transaction. Please try another card or payment method.'));
                }
                break;
            default:
                $transaction = $braintree->sale($this->context->cart, $id_account_braintree, Tools::getValue('payment_method_nonce'), Tools::getValue('deviceData'));

                if (!$transaction) {
                    $paypal->reset_context();
                    $this->redirectFailedPayment($this->getErrorMessageByCode($braintree->error));
                }
                $id_braintree_presta = $braintree->saveTransaction(array('id_cart' => $this->context->cart->id, 'nonce_payment_token' => Tools::getValue('payment_method_nonce'), 'client_token' => Tools::getValue('client_token'), 'datas' => Tools::getValue('deviceData')));

                $transactionDetail = $this->getDetailsTransaction($transaction->id, $transaction->status);
                $paypal->validateOrder($this->context->cart->id, (Configuration::get('PAYPAL_CAPTURE')?Configuration::get('PAYPAL_BRAINTREE_OS_AWAITING'):Configuration::get('PS_OS_PAYMENT')), $transaction->amount, 'Braintree', $paypal->l('Payment accepted.'), $transactionDetail, $this->context->cart->id_currency, false, $this->context->customer->secure_key);
                $paypal->reset_context();
                $order_id = Order::getOrderByCartId($this->context->cart->id);
                $braintree->updateTransaction($id_braintree_presta, $transaction->id, $order_id);
                $this->redirectConfirmation($paypal->id, $this->context->cart->id, $order_id);
                break;
        }
    }

    public function redirectFailedPayment($error = '')
    {
        if (Configuration::get('PS_ORDER_PROCESS_TYPE')) {
            Tools::redirect('index.php?controller=order-opc&isPaymentStep=true&bt_error_msg='.urlencode($error));
        } else {
            Tools::redirect('index.php?controller=order&step=3&bt_error_msg='.urlencode($error));
        }
    }

    public function redirectConfirmation($id_paypal, $id_cart, $id_order)
    {
        Tools::redirect($this->context->link->getPageLink('order-confirmation.php?id_module='.$id_paypal.'&id_cart='.$id_cart.'&id_order='.$id_order.'&key='.Context::getContext()->customer->secure_key.'&braintree=1'));
    }
    
    public function getDetailsTransaction($transaction_id, $status)
    {
        $currency = new Currency($this->context->cart->id_currency);
        return array(
            'currency' => pSQL($currency->iso_code),
            'id_invoice' => null,
            'id_transaction' => pSQL($transaction_id),
            'transaction_id' => pSQL($transaction_id),
            'total_paid' => (float) pSQL($this->context->cart->getOrderTotal()),
            'shipping' => (float) pSQL($this->context->cart->getTotalShippingCost()),
            'payment_status' => $status,
            'payment_date' => date('Y-m-d H:i:s'),
        );
    }


    private function getErrorMessageByCode($code)
    {
        $module = new PayPal();
        switch ($code) {
            case 'processor_declined':
                $message = $module->l('The card used has probably been reported by your bank as lost, stolen or suspected of fraud.');
                break;
            case 'failed':
                $message = $module->l('An error occurred while sending the transaction.');
                break;
            case 'authorization_expired':
                $message = $module->l('The authorization of your banking transaction has expired.');
                break;
            case 'gateway_rejected':
                $message = $module->l('Your transaction was rejected for security reasons.');
                break;
            default:
                $message = $module->l('Your transaction isn\'t valid : ').$code;
        }
        return $message;
    }

    public function getOrderInformation()
    {
        $customer = new Customer($this->context->cart->id_customer);
        $address = new Address($this->context->cart->id_address_delivery);
        $country = new Country($address->id_country);
        $iso = '';

        if ($address->id_state) {
            $state = new State((int) $address->id_state);
            $iso = $state->iso_code;
        }

        $responseContent = array(
            'success' => true,
            'use3dVerification' => (int)Configuration::get('PAYPAL_USE_3D_SECURE'),
            'orderInformation' => array(
                'amount' => $this->context->cart->getOrderTotal(true, Cart::BOTH),
                'email' => $customer->email,
                'billingAddress' => array(
                    'givenName' => $customer->firstname,
                    'surneme' => $customer->lastname,
                    'phoneNumber' => $address->phone,
                    'streetAddress' => $address->address1,
                    'locality' => $address->city,
                    'countryCodeAlpha2' => $country->iso_code,
                    'region' => $iso,
                    'postalCode' => $address->postcode
                ),
                'additionalInformation' => array(
                    'shippingGivenName' => $address->firstname,
                    'shippingSurname' => $address->lastname,
                    'shippingPhone' => $address->phone,
                    'shippingAddress' => array(
                        'streetAddress' => $address->address1,
                        'locality' => $address->city,
                        'countryCodeAlpha2' => $country->iso_code,
                        'region' => $iso,
                        'postalCode' => $address->postcode
                    )
                )
            )
        );

        die(Tools::jsonEncode($responseContent));
    }
}
