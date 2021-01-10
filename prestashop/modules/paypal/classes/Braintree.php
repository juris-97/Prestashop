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

include_once _PS_MODULE_DIR_.'paypal/api/sdk/braintree/lib/Braintree.php';

class PrestaBraintree
{

    public $gateway;
    public $error;

    /**
     * initialize config of braintree
     */
    private function initConfig($sandboxMode = null)
    {
        $configurations = $this->getConfigurations($sandboxMode);
        $this->gateway = new Braintree_Gateway($configurations);
        $this->error = '';
    }

    /**
     * @param $id_account_braintree
     * @return bool
     */
    public function createToken($id_account_braintree)
    {
        try {
            $this->initConfig();

            $clientToken = $this->gateway->clientToken()->generate();
            
            return $clientToken;
        } catch (Exception $e) {
            $this->addLog($e->getCode().'; '.$e->getMessage());
            return false;
        }
    }

    public function isConfigured($sandboxMode = null)
    {
        $this->initConfig($sandboxMode);
        return $this->createToken(null) !== false;
    }

    /**
     * @param $id_account_braintree
     * @return mixed
     */
    public function sale($cart, $id_account_braintree, $token_payment, $device_data)
    {

        $this->initConfig();

        $address_billing = new Address($cart->id_address_invoice);
        $country_billing = new Country($address_billing->id_country);
        $address_shipping = new Address($cart->id_address_delivery);
        $country_shipping = new Country($address_shipping->id_country);

        try {
            $data = array(
                'amount'                => $cart->getOrderTotal(),
                'paymentMethodNonce'    => $token_payment,//'fake-processor-declined-visa-nonce',//
                'merchantAccountId'     => $id_account_braintree,
                'orderId'               => $cart->id,
                'channel'               => 'PrestaShop_Cart_Braintree',
                'billing' => array(
                    'firstName'         => $address_billing->firstname,
                    'lastName'          => $address_billing->lastname,
                    'company'           => $address_billing->company,
                    'streetAddress'     => $address_billing->address1,
                    'extendedAddress'   => $address_billing->address2,
                    'locality'          => $address_billing->city,
                    'postalCode'        => $address_billing->postcode,
                    'countryCodeAlpha2' => $country_billing->iso_code,
                ),
                'shipping' => array(
                    'firstName'         => $address_shipping->firstname,
                    'lastName'          => $address_shipping->lastname,
                    'company'           => $address_shipping->company,
                    'streetAddress'     => $address_shipping->address1,
                    'extendedAddress'   => $address_shipping->address2,
                    'locality'          => $address_shipping->city,
                    'postalCode'        => $address_shipping->postcode,
                    'countryCodeAlpha2' => $country_shipping->iso_code,
                ),
                "deviceData"            => $device_data,
                'options' => array(
                    'submitForSettlement' => !Configuration::get('PAYPAL_CAPTURE'),
                    'three_d_secure' => array(
                        'required' => Configuration::get('PAYPAL_USE_3D_SECURE')
                    )
                )
            );
            
            $result = $this->gateway->transaction()->sale($data);

            if (($result instanceof Braintree_Result_Successful) && $result->success && $this->isValidStatus($result->transaction->status)) {
                return $result->transaction;
            } else {
                $log = '### Braintree transaction error # '.date('Y-m-d H:i:s').' ###'."\n";
                $log .= '## cart id # '.$cart->id.' ##'."\n";
                $log .= '## amount # '.$cart->getOrderTotal().' ##'."\n";
                $log .= '## Braintree error message ##'."\n";

                $log .= '# '.$result->message.' #'."\n";

                foreach ($result->errors->deepAll() as $error) {
                    $log .= '# error code: '.$error->code.' # message: '.$error->message.' #';
                }

                file_put_contents(_PS_MODULE_DIR_.'paypal/log/braintree_log.txt', $log, FILE_APPEND);

                $this->error = $result->transaction->status;
            }
        } catch (Exception $e) {
            $this->error = $e->getCode().' : '.$e->getMessage();
            return false;
        }

        return false;
    }

    public function saveTransaction($data)
    {
        Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'paypal_braintree`(`id_cart`,`nonce_payment_token`,`client_token`,`datas`)
            VALUES (\''.pSQL($data['id_cart']).'\',\''.pSQL($data['nonce_payment_token']).'\',\''.pSQL($data['client_token']).'\',\''.pSQL($data['datas']).'\')');
        return Db::getInstance()->Insert_ID();
    }

    public function updateTransaction($braintree_id, $transaction, $id_order)
    {
        Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'paypal_braintree` set transaction=\''.pSQL($transaction).'\', id_order = \''.pSQL($id_order).'\' WHERE id_paypal_braintree = '.(int)$braintree_id);
    }

    public function checkStatus($id_cart)
    {
        $this->initConfig();
        try {
            $collection = $this->gateway->transaction()->search(
                array(
                    Braintree_TransactionSearch::orderId()->is($id_cart)
                )
            );

            $transaction = $this->gateway->transaction()->find($collection->_ids[0]);
        } catch (Exception $e) {
            $this->error = $e->getCode().' : '.$e->getMessage();
            return false;
        }
        return $transaction;
    }

    public function cartStatus($id_cart)
    {

        $sql = 'SELECT *
        FROM '._DB_PREFIX_.'paypal_braintree
        WHERE id_cart = '.(int)$id_cart;

        $result = Db::getInstance()->getRow($sql);
        if (!empty($result['id_paypal_braintree'])) {
            if (!empty($result['id_order'])) {
                return 'alreadyUse';
            }
            return 'alreadyTry';
        } else {
            return false;
        }
    }

    public function getTransactionId($id_order)
    {
        $result = Db::getInstance()->getValue('SELECT transaction FROM `'._DB_PREFIX_.'paypal_braintree` WHERE id_order = '.(int)$id_order);
        return $result;
    }

    public function getTransactionStatus($transactionId)
    {
        $this->initConfig();

        try {
            $result = $this->gateway->transaction()->find($transactionId);

            return $result->status;
        } catch (Exception $e) {
            $this->addLog($e->getCode().'; '.$e->getMessage());
            return false;
        }
    }

    public function refund($transactionId, $amount)
    {
        $this->initConfig();
        try {
            $result = $this->gateway->transaction()->refund($transactionId, $amount);

            if ($result->success) {
                return true;
            } else {
                $errors = $result->errors->deepAll();
                foreach ($errors as $error) {
                    // if transaction already total refund
                    if ($error->code == Braintree_Error_Codes::TRANSACTION_HAS_ALREADY_BEEN_REFUNDED) {
                        return true;
                    }
                }
                return false;
            }
        } catch (Exception $e) {
            $this->addLog($e->getCode().'; '.$e->getMessage());
            return false;
        }
    }


    public function submitForSettlement($transaction_id, $amount)
    {
        $this->initConfig();
        try {
            $result = $this->gateway->transaction()->submitForSettlement($transaction_id, $amount);
            if ($result instanceof Braintree_Result_Successful && $result->success) {
                return true;
            } else {
                $errors = $result->errors->deepAll();
                foreach ($errors as $error) {
                    // if transaction already total refund
                    if ($error->code == Braintree_Error_Codes::TRANSACTION_CANNOT_SUBMIT_FOR_SETTLEMENT) {
                        return true;
                    }
                }
                if ($result->transaction->status == 'Authorization_expired') {
                    $this->error = $result->transaction->status;
                }
            }
        } catch (Exception $e) {
            $this->addLog($e->getCode().'; '.$e->getMessage());
            return false;
        }
        return false;
    }

    public function void($transaction_id)
    {
        $this->initConfig();
        try {
            $result = $this->gateway->transaction()->void($transaction_id);
            if ($result instanceof Braintree_Result_Successful && $result->success) {
                return true;
            }
        } catch (Exception $e) {
            $this->addLog($e->getCode().'; '.$e->getMessage());
            return false;
        }
    }

    public function isValidStatus($status)
    {
        return in_array($status, array('submitted_for_settlement','authorized','settled'));
    }

    protected function getConfigurations($sandboxMode = null)
    {
        $configurations = array();
        if ($this->useToken()) {
            $this->_checkToken();
            $configurations['accessToken'] = Configuration::get('PAYPAL_BRAINTREE_ACCESS_TOKEN');
        } else {
            if ($sandboxMode !== null) {
                $this->mode = $sandboxMode ? 'SANDBOX' : 'LIVE';
            } else {
                $this->mode = Configuration::get('PAYPAL_SANDBOX') ? 'SANDBOX' : 'LIVE';
            }

            $configurations['environment'] = $this->mode == 'SANDBOX' ? 'sandbox' : 'production';
            $configurations['publicKey'] = Configuration::get('PAYPAL_BRAINTREE_PUB_KEY_' . $this->mode);
            $configurations['privateKey'] = Configuration::get('PAYPAL_BRAINTREE_PRIV_KEY_' . $this->mode);
            $configurations['merchantId'] = Configuration::get('PAYPAL_BRAINTREE_MERCHANT_ID_' . $this->mode);
        }

        return $configurations;
    }

    public function useToken()
    {
        $return = true;
        $mode = Configuration::get('PAYPAL_SANDBOX') ? 'SANDBOX' : 'LIVE';
        $return &= Configuration::get('PAYPAL_BRAINTREE_PUB_KEY_' . $mode) == false;
        $return &= Configuration::get('PAYPAL_BRAINTREE_PRIV_KEY_' . $mode) == false;
        $return &= Configuration::get('PAYPAL_BRAINTREE_MERCHANT_ID_' . $mode) == false;
        $return &= Configuration::get('PAYPAL_BRAINTREE_ACCESS_TOKEN') != false;

        return $return;
    }

    /**
     * Check if token is still valid by comparing the "expiresAt" parameter to the time
     */
    private function _checkToken()
    {
        if (Configuration::get('PAYPAL_BRAINTREE_EXPIRES_AT') && Configuration::get('PAYPAL_BRAINTREE_REFRESH_TOKEN')) {
            $datetime_bt = DateTime::createFromFormat(DateTime::ISO8601, Configuration::get('PAYPAL_BRAINTREE_EXPIRES_AT'));
            $datetime_now = new DateTime();
            $datetime_bt->format(DateTime::ISO8601);
            $datetime_now->format(DateTime::ISO8601);
            if ($datetime_now->getTimestamp() >= $datetime_bt->getTimestamp()) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, PROXY_HOST.'prestashop/refreshToken?refreshToken='.urlencode(Configuration::get('PAYPAL_BRAINTREE_REFRESH_TOKEN')));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                $resp = curl_exec($ch);
                curl_close($ch);
                $json = Tools::jsonDecode($resp);
                Configuration::updateValue('PAYPAL_BRAINTREE_ACCESS_TOKEN', $json->data->accessToken);
                Configuration::updateValue('PAYPAL_BRAINTREE_REFRESH_TOKEN', $json->data->refreshToken);
                Configuration::updateValue('PAYPAL_BRAINTREE_EXPIRES_AT', $json->data->expiresAt);
                return true;
            }
            return true;
        } else {
            return false;
        }
    }

    public function addLog($message)
    {
        if (version_compare(_PS_VERSION_, '1.6', '<')) {
            Logger::addLog($message);
        } else {
            PrestaShopLogger::addLog($message);
        }
    }
}
