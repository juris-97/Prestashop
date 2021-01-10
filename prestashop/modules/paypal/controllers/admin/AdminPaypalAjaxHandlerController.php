<?php


class AdminPaypalAjaxHandlerController extends ModuleAdminControllerCore
{
    public function __construct()
    {
        parent::__construct();
    }

    public function displayAjaxHandlePsCheckoutAction()
    {
        $action = Tools::getValue('actionHandled');
        $response = array();

        switch ($action) {
            case 'close':
                $this->module->setPsCheckoutMessageValue(true);
                break;
            case 'install':
                if (is_dir(_PS_MODULE_DIR_ . 'ps_checkout') == false) {
                    $response = array(
                        'redirect' => true,
                        'url' => 'https://addons.prestashop.com/en/payment-card-wallet/46347-prestashop-checkout-built-with-paypal.html'
                    );
                } else {
                    if ($this->installPsCheckout()) {
                        $response = array(
                            'redirect' => true,
                            'url' => $this->context->link->getAdminLink('AdminModules') . '&configure=ps_checkout'
                        );
                    } else {
                        $response = array(
                            'redirect' => false,
                            'url' => 'someUrl'
                        );
                    }
                }
                break;
        }

        die(json_encode($response));
    }

    protected function installPsCheckout()
    {
        if (Module::isInstalled('ps_checkout')) {
            return true;
        }

        $module = Module::getInstanceByName('ps_checkout');
        return $module->install();
    }
}