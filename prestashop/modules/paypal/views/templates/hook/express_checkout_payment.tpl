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

{if $smarty.const._PS_VERSION_ >= 1.6}

<div class="row">
	<div class="col-xs-12">
        <p class="payment_module paypal">
        	{if $use_paypal_in_context}
				<a href="javascript:void(0)" onclick="" id="paypal_process_payment" title="{l s='Pay with PayPal' mod='paypal'}">
			{else}
				<a href="javascript:$('#paypal_payment_form_payment').submit();" title="{l s='Pay with PayPal' mod='paypal'}">
			{/if}

					<img
							src="/modules/paypal/views/img/logos/FR_pp_cc_mark_74x46.jpg"
							alt="{l s='Pay with your card or your PayPal account' mod='paypal'}" />

                    {if isset($braintreeToken)}
                    {l s='Pay with PayPal' mod='paypal'}
                    {else}
					{l s='Pay with PayPal' mod='paypal'}
                    {/if}

			</a>
		</p>
    </div>
</div>

<style>
	p.payment_module.paypal a
	{ldelim}
		padding-left:17px;
	{rdelim}
</style>
{else}
<p class="payment_module">
		<a href="javascript:void(0)" id="paypal_process_payment" title="{l s='Pay with PayPal' mod='paypal'}">
			<img
					src="{$logos.LocalPayPalLogoMedium|escape:'htmlall':'UTF-8'}"
					alt="{l s='Pay with your card or your PayPal account' mod='paypal'}" />

			{l s='Pay with your card or your PayPal account' mod='paypal'}

		</a>
</p>

{/if}


{if $use_paypal_in_context}
	<input type="hidden" id="in_context_checkout_enabled" value="1">
{else}
<script>
    $(document).ready(function(){
        $(document).on('click', '#paypal_process_payment', function(){
            $('#paypal_payment_form_payment').submit();
        });
    });
</script>
{/if}
<form id="paypal_payment_form_payment" class="paypal_payment_form" action="{$base_dir_ssl|escape:'htmlall':'UTF-8'}modules/paypal/express_checkout/payment.php" data-ajax="false" title="{l s='Pay with PayPal' mod='paypal'}" method="post">
	<input type="hidden" name="express_checkout" value="{$PayPal_payment_type|escape:'htmlall':'UTF-8'}"/>
	<input type="hidden" name="current_shop_url" value="{$PayPal_current_page|escape:'htmlall':'UTF-8'}" />
	<input type="hidden" name="bn" value="{$PayPal_tracking_code|escape:'htmlall':'UTF-8'}" />
</form>