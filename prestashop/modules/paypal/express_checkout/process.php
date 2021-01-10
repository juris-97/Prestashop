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
 *
 */

include_once _PS_MODULE_DIR_.'paypal/paypal.php';
include_once _PS_MODULE_DIR_.'paypal/api/paypal_lib.php';

class PaypalExpressCheckout extends Paypal
{
    public $logs = array();

    public $method_version = '106';

    public $method;

    /** @var currency Currency used for the payment process **/
    public $currency;

    /** @var decimals Used to set prices precision **/
    public $decimals;

    /** @var result Contains the last request result **/
    public $result;

    /** @var token Contains the last token **/
    public $token;

    /* Depending of the type set, id_cart or id_product will be set */
    public $id_cart;

    // Depending of the type set, id_cart or id_product will be set
    public $id_product;

    public $id_p_attr;

    public $quantity;

    public $payer_id;

    public $available_type = array('cart', 'product', 'payment_cart');

    public $total_different_product;

    public $product_list = array();

    /* Used to know if user can validated his payment after shipping / address selection */
    public $ready = false;

    /* Take for now cart or product value */
    public $type = false;

    public static $cookie_name = 'express_checkout';

    public $cookie_key = array(
        'token', 'id_product', 'id_p_attr',
        'quantity', 'type', 'total_different_product',
        'secure_key', 'ready', 'payer_id',
    );

    public function __construct($type = false)
    {
        parent::__construct();

        // If type is sent, the cookie has to be delete
        if ($type) {
            unset($this->context->cookie->{self::$cookie_name});
            $this->setExpressCheckoutType($type);
        }

        // Store back the PayPal data if present under the cookie
        if (isset($this->context->cookie->{self::$cookie_name})) {
            $paypal = unserialize($this->context->cookie->{self::$cookie_name});

            foreach ($this->cookie_key as $key) {
                $this->{$key} = $paypal[$key];
            }
        }

        $this->currency = new Currency((int) $this->context->cart->id_currency);

        if (!Validate::isLoadedObject($this->currency)) {
            $this->_errors[] = $this->l('Not a valid currency');
        }

        if (count($this->_errors)) {
            return false;
        }

        $currency_mode = Currency::getPaymentCurrenciesSpecial($this->id);
        $mode_id = $currency_mode['id_currency'];
        if ($mode_id == -1) {
            $iso = Context::getContext()->currency->iso_code;
        } else if ($mode_id == -2) {
            $currency = new Currency((int)Configuration::get('PS_CURRENCY_DEFAULT'));
            $iso = $currency->iso_code;
        } else {
            $pp_currency = new Currency((int)$mode_id);
            $iso = $pp_currency->iso_code;
        }

        $currency_wt_decimal = array('HUF', 'JPY', 'TWD');
        if (in_array($iso, $currency_wt_decimal)) {
            $this->decimals = (int)0;
        } elseif (Configuration::hasKey('PS_PRICE_DISPLAY_PRECISION')) {
            $this->decimals = (int)Configuration::get('PS_PRICE_DISPLAY_PRECISION');
        } else {
            $this->decimals = (int)2;
        }
    }

    // Will build the product_list depending of the type
    private function initParameters()
    {
        if (!$this->context->cart || !$this->context->cart->id) {
            return false;
        }

        $cart_currency = new Currency((int) $this->context->cart->id_currency);
        $currency_module = $this->getCurrency((int) $this->context->cart->id_currency);

        if ($cart_currency !== $currency_module) {
            $this->context->cart->id_currency = $currency_module->id;
            $this->context->cart->update();
        }

        $this->context->currency = $currency_module;
        $this->product_list = $this->context->cart->getProducts(true);
        return (bool) count($this->product_list);
    }

    public function setExpressCheckout($access_token = false)
    {
        $this->method = 'SetExpressCheckout';
        $fields = array();
        $this->setCancelUrl($fields);

        // Only this call need to get the value from the $_GET / $_POST array
        if (!$this->initParameters(true) || !$fields['CANCELURL']) {
            return false;
        }

        // Set payment detail (reference)
        $this->_setPaymentDetails($fields);
        $fields['SOLUTIONTYPE'] = 'Sole';
        $fields['LANDINGPAGE'] = 'Login';

        // Seller informations
        $fields['USER'] = Configuration::get('PAYPAL_API_USER');
        $fields['PWD'] = Configuration::get('PAYPAL_API_PASSWORD');
        $fields['SIGNATURE'] = Configuration::get('PAYPAL_API_SIGNATURE');

        if ($access_token) {
            $fields['IDENTITYACCESSTOKEN'] = $access_token;
        }

        if (Country::getIsoById(Configuration::get('PAYPAL_COUNTRY_DEFAULT')) == 'de') {
            $fields['BANKTXNPENDINGURL'] = 'payment.php?banktxnpendingurl=true';
        }

        $this->callAPI($fields);
        $this->_storeToken();
    }

    public function setCancelUrl(&$fields)
    {
        $url = urldecode(Tools::getValue('current_shop_url'));
        $parsed_data = parse_url($url);

        $parsed_data['scheme'] .= '://';

        if (isset($parsed_data['path'])) {
            $parsed_data['path'] .= '?step=3&';
            $parsed_data['query'] = isset($parsed_data['query']) ? $parsed_data['query'] : null;
        } else {
            $parsed_data['path'] = '?step=3&';
            $parsed_data['query'] = '/'.(isset($parsed_data['query']) ? $parsed_data['query'] : null);
        }

        $cancel_url = Tools::secureReferrer(implode($parsed_data));

        if (!empty($cancel_url)) {
            $fields['CANCELURL'] = $cancel_url;
        }
    }

    public function getExpressCheckout()
    {
        $this->method = 'GetExpressCheckoutDetails';
        $fields = array();
        $fields['TOKEN'] = $this->token;

        $this->initParameters();
        $this->callAPI($fields);

        // The same token of SetExpressCheckout
        $this->_storeToken();
    }

    public function doExpressCheckout()
    {
        $this->method = 'DoExpressCheckoutPayment';
        $fields = array();
        $fields['TOKEN'] = $this->token;
        $fields['PAYERID'] = $this->payer_id;

        if (Configuration::get('PAYPAL_COUNTRY_DEFAULT') == 1) {
            $fields['BANKTXNPENDINGURL'] = '';
        }

        if (count($this->product_list) <= 0) {
            $this->initParameters();
        }

        // Set payment detail (reference)
        $this->_setPaymentDetails($fields);

        $this->callAPI($fields);

        $this->result += $fields;
    }

    private function callAPI($fields)
    {
        $this->logs = array();
        $paypal_lib = new PaypalLib();

        $this->result = $paypal_lib->makeCall($this->getAPIURL(), $this->getAPIScript(), $this->method, $fields, $this->method_version);
        $this->logs = array_merge($this->logs, $paypal_lib->getLogs());

        $this->_storeToken();
    }

    private function _setPaymentDetails(&$fields)
    {
        // Required field
        $fields['RETURNURL'] = PayPal::getShopDomainSsl(true, true)._MODULE_DIR_.$this->name.'/express_checkout/payment.php';
        $fields['NOSHIPPING'] = '1';
        $fields['BUTTONSOURCE'] = $this->getTrackingCode((int) Configuration::get('PAYPAL_PAYMENT_METHOD'));

        // Products
        $taxes = $total = 0;
        $index = -1;

        // Set cart products list
        $this->setProductsList($fields, $index, $total, $taxes);
        $this->setDiscountsList($fields, $index, $total, $taxes);
        $this->setGiftWrapping($fields, $index, $total);

        // Payment values
        $this->setPaymentValues($fields, $index, $total, $taxes);

        $id_address = (int) $this->context->cart->id_address_delivery;

        if (($id_address == 0) && ($this->context->customer)) {
            $id_address = Address::getFirstCustomerAddressId($this->context->customer->id);
        }

        if ($id_address && method_exists($this->context->cart, 'isVirtualCart') && !$this->context->cart->isVirtualCart()) {
            $this->setShippingAddress($fields, $id_address);
        } else {
            $fields['NOSHIPPING'] = '0';
        }

        foreach ($fields as &$field) {
            if (is_numeric($field)) {
                $field = str_replace(',', '.', $field);
            }
        }
    }

    private function setShippingAddress(&$fields, $id_address)
    {
        $address = new Address($id_address);

        //We allow address modification when using express checkout shortcut
        if ($this->type != 'payment_cart') {
            $fields['ADDROVERRIDE'] = '0';
            $fields['NOSHIPPING'] = '0';
        } else {
            $fields['ADDROVERRIDE'] = '1';
        }

        $fields['EMAIL'] = $this->context->customer->email;
        $fields['PAYMENTREQUEST_0_SHIPTONAME'] = $address->firstname.' '.$address->lastname;
        $fields['PAYMENTREQUEST_0_SHIPTOPHONENUM'] = (empty($address->phone)) ? $address->phone_mobile : $address->phone;
        $fields['PAYMENTREQUEST_0_SHIPTOSTREET'] = $address->address1;
        $fields['PAYMENTREQUEST_0_SHIPTOSTREET2'] = $address->address2;
        $fields['PAYMENTREQUEST_0_SHIPTOCITY'] = $address->city;

        if ($address->id_state) {
            $state = new State((int) $address->id_state);
            $fields['PAYMENTREQUEST_0_SHIPTOSTATE'] = $state->iso_code;
        }

        $country = new Country((int) $address->id_country);
        $fields['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE'] = $country->iso_code;
        $fields['PAYMENTREQUEST_0_SHIPTOZIP'] = $address->postcode;
    }

    private function setProductsList(&$fields, &$index, &$total)
    {
        foreach ($this->product_list as $product) {
            $fields['L_PAYMENTREQUEST_0_NUMBER'.++$index] = (int) $product['id_product'];

            $fields['L_PAYMENTREQUEST_0_NAME'.$index] = $product['name'];

            if (isset($product['attributes']) && (empty($product['attributes']) === false)) {
                $fields['L_PAYMENTREQUEST_0_NAME'.$index] .= ' - '.$product['attributes'];
            }

            $fields['L_PAYMENTREQUEST_0_DESC'.$index] = Tools::substr(strip_tags($product['description_short']), 0, 50).'...';

            $price = $product['price_wt'];
            if (version_compare(_PS_VERSION_, '1.6.1', '<')) {
                if (isset($product['ecotax']) && $product['ecotax'] > 0) {
                    $price += $product['ecotax'];
                }
            }

            $fields['L_PAYMENTREQUEST_0_AMT'.$index] = Tools::ps_round($price, $this->decimals);

            $fields['L_PAYMENTREQUEST_0_QTY'.$index] = $product['quantity'];

            $total = $total + ($fields['L_PAYMENTREQUEST_0_AMT'.$index] * $product['quantity']);
        }
    }

    private function setDiscountsList(&$fields, &$index, &$total)
    {
        $discounts = (_PS_VERSION_ < '1.5') ? $this->context->cart->getDiscounts() : $this->context->cart->getCartRules();

        if (count($discounts) > 0) {
            foreach ($discounts as $discount) {
                $fields['L_PAYMENTREQUEST_0_NUMBER'.++$index] = $discount['id_discount'];

                $fields['L_PAYMENTREQUEST_0_NAME'.$index] = $discount['name'];
                if (isset($discount['description']) && !empty($discount['description'])) {
                    $fields['L_PAYMENTREQUEST_0_DESC'.$index] = Tools::substr(strip_tags($discount['description']), 0, 50).'...';
                }

                /* It is a discount so we store a negative value */
                $fields['L_PAYMENTREQUEST_0_AMT'.$index] = -1 * Tools::ps_round($discount['value_real'], $this->decimals);
                $fields['L_PAYMENTREQUEST_0_QTY'.$index] = 1;

                $total = Tools::ps_round($total + $fields['L_PAYMENTREQUEST_0_AMT'.$index], $this->decimals);
            }
        }
    }

    private function setGiftWrapping(&$fields, &$index, &$total)
    {
        if ($this->context->cart->gift == 1) {
            $gift_wrapping_price = $this->getGiftWrappingPrice();

            $fields['L_PAYMENTREQUEST_0_NAME'.++$index] = $this->l('Gift wrapping');

            $fields['L_PAYMENTREQUEST_0_AMT'.$index] = Tools::ps_round($gift_wrapping_price, $this->decimals);
            $fields['L_PAYMENTREQUEST_0_QTY'.$index] = 1;

            $total = Tools::ps_round($total + $gift_wrapping_price, $this->decimals);
        }
    }

    private function setPaymentValues(&$fields, &$index, &$total, &$taxes)
    {
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            $shipping_cost_wt = $this->context->cart->getOrderShippingCost();
        } else {
            $shipping_cost_wt = $this->context->cart->getTotalShippingCost();
        }

        if ((bool) Configuration::get('PAYPAL_CAPTURE')) {
            $fields['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Authorization';
        } else {
            $fields['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
        }

        $currency = new Currency((int) $this->context->cart->id_currency);
        $fields['PAYMENTREQUEST_0_CURRENCYCODE'] = $currency->iso_code;

        /**
         * If the total amount is lower than 1 we put the shipping cost as an item
         * so the payment could be valid.
         */
        if ($total <= 1) {
            $carrier = new Carrier($this->context->cart->id_carrier);
            $fields['L_PAYMENTREQUEST_0_NUMBER'.++$index] = $carrier->id_reference;
            $fields['L_PAYMENTREQUEST_0_NAME'.$index] = $carrier->name;
            $fields['L_PAYMENTREQUEST_0_AMT'.$index] = Tools::ps_round($shipping_cost_wt, $this->decimals);
            $fields['L_PAYMENTREQUEST_0_QTY'.$index] = 1;

            $fields['PAYMENTREQUEST_0_ITEMAMT'] = Tools::ps_round($total, $this->decimals) + Tools::ps_round($shipping_cost_wt, $this->decimals);
            $fields['PAYMENTREQUEST_0_AMT'] = $total + Tools::ps_round($shipping_cost_wt, $this->decimals);
        } else {
            if ($currency->iso_code == 'HUF') {
                $fields['PAYMENTREQUEST_0_SHIPPINGAMT'] = round($shipping_cost_wt);
                $fields['PAYMENTREQUEST_0_ITEMAMT'] = Tools::ps_round($total, $this->decimals);
                $fields['PAYMENTREQUEST_0_AMT'] = sprintf('%.2f', ($total + $fields['PAYMENTREQUEST_0_SHIPPINGAMT']));
            } else {
                $fields['PAYMENTREQUEST_0_SHIPPINGAMT'] = sprintf('%.2f', $shipping_cost_wt);
                $fields['PAYMENTREQUEST_0_ITEMAMT'] = Tools::ps_round($total, $this->decimals);
                $fields['PAYMENTREQUEST_0_AMT'] = sprintf('%.2f', ($total + $fields['PAYMENTREQUEST_0_SHIPPINGAMT']));
            }
        }
    }

    private function _storeToken()
    {
        if (is_array($this->result) && isset($this->result['TOKEN'])) {
            $this->token = (string) $this->result['TOKEN'];
        }
    }

    // Store data for the next reloading page
    private function _storeCookieInfo()
    {
        $tab = array();

        foreach ($this->cookie_key as $key) {
            $tab[$key] = $this->{$key};
        }

        $this->context->cookie->{self::$cookie_name} = serialize($tab);
    }

    public function displayPaypalInContextCheckout()
    {
        $this->secure_key = $this->getSecureKey();
        $this->_storeCookieInfo();
        echo $this->token;
        die;
    }

    public function hasSucceedRequest()
    {
        if (is_array($this->result)) {
            foreach (array('ACK', 'PAYMENTINFO_0_ACK') as $key) {
                if (isset($this->result[$key]) && Tools::strtoupper($this->result[$key]) == 'SUCCESS') {
                    return true;
                }
            }
        }

        return false;
    }

    private function getSecureKey()
    {
        if (!count($this->product_list)) {
            $this->initParameters();
        }

        $key = array();

        foreach ($this->product_list as $product) {
            $id_product = $product['id_product'];
            $id_product_attribute = $product['id_product_attribute'];
            $quantity = $product['quantity'];

            $key[] = $id_product.$id_product_attribute.$quantity._COOKIE_KEY_;
        }

        return md5(serialize($key));
    }

    public function isProductsListStillRight()
    {
        return $this->secure_key == $this->getSecureKey();
    }

    public function setExpressCheckoutType($type)
    {
        if (in_array($type, $this->available_type)) {
            $this->type = $type;
            return true;
        }
        return false;
    }

    public function redirectToAPI()
    {
        $this->secure_key = $this->getSecureKey();
        $this->_storeCookieInfo();

        if ($this->useMobile()) {
            $url = '/cgi-bin/webscr?cmd=_express-checkout-mobile';
        } else {
            $url = '/websc&cmd=_express-checkout';
        }

        $url .= '&useraction=commit';

        if (($this->method == 'SetExpressCheckout') && (Configuration::get('PAYPAL_COUNTRY_DEFAULT') == 1) && ($this->type == 'payment_cart')) {
            $url .= '&useraction=commit';
        }

        Tools::redirectLink('https://'.$this->getPayPalURL().$url.'&token='.urldecode($this->token));
        exit(0);
    }

    public function redirectToCheckout($customer, $redirect = false)
    {
        $this->ready = true;
        $this->_storeCookieInfo();

        $this->context->cookie->id_customer = (int) $customer->id;
        $this->context->cookie->customer_lastname = $customer->lastname;
        $this->context->cookie->customer_firstname = $customer->firstname;
        $this->context->cookie->passwd = $customer->passwd;
        $this->context->cookie->email = $customer->email;
        $this->context->cookie->is_guest = $customer->isGuest();
        $this->context->cookie->logged = 1;

        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            Module::hookExec('authentication');
        } else {
            Hook::exec('authentication');
        }

        if ($redirect) {
            $link = $this->context->link->getPageLink('order.php', false, null, array('step' => '1'));
            Tools::redirectLink($link);
            exit(0);
        }
    }
}
