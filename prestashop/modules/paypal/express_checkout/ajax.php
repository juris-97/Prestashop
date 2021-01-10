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

include_once dirname(__FILE__).'/../../../config/config.inc.php';
include_once _PS_ROOT_DIR_.'/init.php';
include_once dirname(__FILE__).'/../paypal.php';

// Ajax query
$quantity = Tools::getValue('get_qty');

if (Configuration::get('PS_CATALOG_MODE') == 1) {
    die('0');
}

if ($quantity && $quantity > 0) {
    /* Ajax response */
    $id_product = (int) Tools::getValue('id_product');
    $id_product_attribute = (int) Tools::getValue('id_product_attribute');
    $product_quantity = Product::getQuantity($id_product, $id_product_attribute);
    $product = new Product($id_product);

    if (!$product->available_for_order) {
        die('0');
    }

    if ($product_quantity > 0) {
        die('1');
    }

    if ($product_quantity <= 0 && $product->isAvailableWhenOutOfStock((int) $product->out_of_stock)) {
        die('1');
    }
}
die('0');
