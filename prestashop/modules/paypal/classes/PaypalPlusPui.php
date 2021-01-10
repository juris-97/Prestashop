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

class PaypalPlusPui extends ObjectModel
{

    public $id_paypal_plus_pui;
    public $id_order;
    public $pui_informations;

    public static $definition = array(
        'table' => 'paypal_plus_pui',
        'primary' => 'id_paypal_plus_pui',
        'fields' => array(
            'id_order' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'pui_informations' => array('type' => self::TYPE_STRING),
        ),
    );


    public static function getByIdOrder($id_order)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('paypal_plus_pui');
        $sql->where('id_order = '.(int)$id_order);
        return Db::getInstance()->getRow($sql);
    }
}
