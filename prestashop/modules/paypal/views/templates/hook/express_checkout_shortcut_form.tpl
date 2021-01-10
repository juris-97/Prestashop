{*
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
*}

<form id="paypal_payment_form_cart" class="paypal_payment_form" action="{$base_dir_ssl|escape:'htmlall':'UTF-8'}modules/paypal/express_checkout/payment.php" title="{l s='Pay with PayPal' mod='paypal'}" method="post" data-ajax="false">
	{if isset($smarty.get.id_product)}<input type="hidden" name="id_product" value="{$smarty.get.id_product|intval}" />{/if}
	<!-- Change dynamicaly when the form is submitted -->
	{if isset($product_minimal_quantity)}
	<input type="hidden" name="quantity" value="{$product_minimal_quantity|escape:'htmlall':'UTF-8'}" />
	{else}
	<input type="hidden" name="quantity" value="1" />
	{/if}
	{if isset($id_product_attribute_ecs)}
	<input type="hidden" name="id_p_attr" value="{$id_product_attribute_ecs|escape:'htmlall':'UTF-8'}" />
	{else}
	<input type="hidden" name="id_p_attr" value="" />
	{/if}
	<input type="hidden" name="express_checkout" value="{$PayPal_payment_type|escape:'htmlall':'UTF-8'}"/>
	<input type="hidden" name="current_shop_url" value="{$PayPal_current_page|escape:'htmlall':'UTF-8'}" />
	<input type="hidden" name="bn" value="{$PayPal_tracking_code|escape:'htmlall':'UTF-8'}" />
</form>

{if $use_paypal_in_context}
	<input type="hidden" id="in_context_checkout_enabled" value="1">
{else}
	<input type="hidden" id="in_context_checkout_enabled" value="0">
{/if}


