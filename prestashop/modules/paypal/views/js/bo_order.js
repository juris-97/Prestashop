/*
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

document.addEventListener("DOMContentLoaded", function () {

    // Make partial order refund in Order page in BO
    $(document).on('click', '#desc-order-partial_refund', function () {
        if ($('#doPartialRefundBraintree').length == 0) {
            var p, label, input; // Create checkbox for Braintree refund

            p = document.createElement('p');
            p.className = 'checkbox';
            label = document.createElement('label');
            label.setAttribute('for', 'doPartialRefundPayPal');
            input = document.createElement('input');
            input.type = 'checkbox';
            input.id = 'doPartialRefundPayPal';
            input.name = 'doPartialRefundPayPal'; // insert checkbox

            label.appendChild(input);
            label.appendChild(document.createTextNode(chb_braintree_refund));
            p.appendChild(label);
            $('button[name=partialRefund]').parent('.partial_refund_fields').prepend(p);
        }
    });

});
