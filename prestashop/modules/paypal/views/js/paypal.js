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


    {literal}

function updateFormDatas()
{
	var nb = $('#quantity_wanted').val();
	var id = $('#idCombination').val();

	$('.paypal_payment_form input[name=quantity]').val(nb);
	$('.paypal_payment_form input[name=id_p_attr]').val(id);
}
	
$(document).ready( function() {
    {/literal}
	{if $ssl_enabled}
	var baseDirPP = baseDir.replace('http:', 'https:');
	{else}
	var baseDirPP = baseDir;
	{/if}
	{literal}
	if($('#in_context_checkout_enabled').val() != 1)
	{
        $(document).on('click','#payment_paypal_express_checkout', function() {
			$('#paypal_payment_form_cart').submit();
			return false;
		});
	}


	var jquery_version = $.fn.jquery.split('.');
	if(jquery_version[0]>=1 && jquery_version[1] >= 7)
	{
		$('body').on('submit',".paypal_payment_form", function () {
			updateFormDatas();
		});
	}
	else {
		$('.paypal_payment_form').live('submit', function () {
			updateFormDatas();
		});
	}

	function displayExpressCheckoutShortcut() {
		var id_product = $('input[name="id_product"]').val();
		var id_product_attribute = $('input[name="id_product_attribute"]').val();
		$.ajax({
			type: "GET",
			url: baseDirPP+'/modules/paypal/express_checkout/ajax.php',
			data: { get_qty: "1", id_product: id_product, id_product_attribute: id_product_attribute },
			cache: false,
			success: function(result) {
				if (result == '1') {
					$('#container_express_checkout').slideDown();
				} else {
					$('#container_express_checkout').slideUp();
				}
				return true;
			}
		});
	}

	$('select[name^="group_"]').change(function () {
		setTimeout(function(){displayExpressCheckoutShortcut()}, 500);
	});

	$('.color_pick').click(function () {
		setTimeout(function(){displayExpressCheckoutShortcut()}, 500);
	});

    if($('body#product').length > 0) {
        setTimeout(function(){displayExpressCheckoutShortcut()}, 500);
    }
	
	{/literal}
	{if isset($paypal_authorization)}
	{literal}
	
		/* 1.5 One page checkout*/
		var qty = $('.qty-field.cart_quantity_input').val();
		$('.qty-field.cart_quantity_input').after(qty);
		$('.qty-field.cart_quantity_input, .cart_total_bar, .cart_quantity_delete, #cart_voucher *').remove();
		
		var br = $('.cart > a').prev();
		br.prev().remove();
		br.remove();
		$('.cart.ui-content > a').remove();
		
		var gift_fieldset = $('#gift_div').prev();
		var gift_title = gift_fieldset.prev();
		$('#gift_div, #gift_mobile_div').remove();
		gift_fieldset.remove();
		gift_title.remove();
		
	{/literal}
	{/if}
	{if isset($paypal_confirmation)}
	{literal}
		
		$('#container_express_checkout').hide();
		if(jquery_version[0] >= 1 && jquery_version[1] >= 7)
		{
			$('body').on('click',"#cgv", function () {
				if ($('#cgv:checked').length != 0)
					$(location).attr('href', '{/literal}{$paypal_confirmation}{literal}');
			});
		}
		else {
			$('#cgv').live('click', function () {
				if ($('#cgv:checked').length != 0)
					$(location).attr('href', '{/literal}{$paypal_confirmation}{literal}');
			});

			/* old jQuery compatibility */
			$('#cgv').click(function () {
				if ($('#cgv:checked').length != 0)
					$(location).attr('href', '{/literal}{$paypal_confirmation}{literal}');
			});
		}

	{/literal}
	{else if isset($paypal_order_opc)}

	{literal}


		var jquery_version = $.fn.jquery.split('.');
		if(jquery_version[0]>=1 && jquery_version[1] >= 7)
		{
			$('body').on('click','#cgv', function() {
				if ($('#cgv:checked').length != 0)
					checkOrder();
			});
		}
		else
		{
			$('#cgv').live('click', function() {
				if ($('#cgv:checked').length != 0)
					checkOrder();
			});

			/* old jQuery compatibility */
			$('#cgv').click(function() {
				if ($('#cgv:checked').length != 0)
					checkOrder();
			});
		}

	{/literal}

	{/if}
	{literal}

	var modulePath = 'modules/paypal';
	var subFolder = '/integral_evolution';

	var fullPath = baseDirPP + modulePath + subFolder;
	var confirmTimer = false;
		
	if ($('form[target="hss_iframe"]').length == 0) {
		if ($('select[name^="group_"]').length > 0)
			displayExpressCheckoutShortcut();
		return false;
	} else {
		checkOrder();
	}

	function checkOrder() {
		if(confirmTimer == false)
			confirmTimer = setInterval(getOrdersCount, 1000);
	}

	{/literal}{if isset($id_cart)}{literal}
	function getOrdersCount() {


		$.get(
			fullPath + '/confirm.php',
			{ id_cart: '{/literal}{$id_cart}{literal}' },
			function (data) {
				if ((typeof(data) != 'undefined') && (data > 0)) {
					clearInterval(confirmTimer);
					window.location.replace(fullPath + '/submit.php?id_cart={/literal}{$id_cart}{literal}');
					$('p.payment_module, p.cart_navigation').hide();
				}
			}
		);
	}
	{/literal}{/if}{literal}
});

{/literal}
