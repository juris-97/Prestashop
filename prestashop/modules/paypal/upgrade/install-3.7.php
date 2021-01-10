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

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_3_7($object, $install = false)
{
    $paypal_version = Configuration::get('PAYPAL_VERSION');

    if ((!$paypal_version) || (empty($paypal_version)) || ($paypal_version < $object->version)) {
        if (!Db::getInstance()->Execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'paypal_login_user`  (
				`id_paypal_login_user` INT(11) AUTO_INCREMENT,
				`id_customer` INT(11) NOT NULL,
				`token_type` VARCHAR(255) NOT NULL,
				`expires_in` VARCHAR(255) NOT NULL,
				`refresh_token` VARCHAR(255) NOT NULL,
				`id_token` VARCHAR(255) NOT NULL,
				`access_token` VARCHAR(255) NOT NULL,
				`account_type` VARCHAR(255) NOT NULL,
				`user_id` VARCHAR(255) NOT NULL,
				`verified_account` VARCHAR(255) NOT NULL,
				`zoneinfo` VARCHAR(255) NOT NULL,
				`age_range` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`id_paypal_login_user`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8')) {
            return false;
        }

        Configuration::updateValue('PAYPAL_VERSION', '3.7.0');
    }

    return true;
}
