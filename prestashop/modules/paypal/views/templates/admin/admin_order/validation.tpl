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
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-heading"><img src="{$base_url|escape:'htmlall':'UTF-8'}modules/{$module_name|escape:'htmlall':'UTF-8'}/{if $order_payment == 'paypal'}logo.gif{else}views/img/braintree.png{/if}" alt="" /> {if $order_payment == 'paypal'}{l s='PayPal Validation' mod='paypal'}{else}{l s='Braintree Validation' mod='paypal'}{/if}</div>
			<form method="post" action="{$smarty.server.REQUEST_URI|escape:'htmlall':'UTF-8'}">
				<input type="hidden" name="id_order" value="{$params.id_order|intval}" />
				<p><b>{l s='Information:' mod='paypal'}</b> {if $order_state == $authorization}{l s='Pending Capture - No shipping' mod='paypal'}{else}{l s='Pending Payment - No shipping' mod='paypal'}{/if}</p>				
				<p class="center">
					<button type="submit" class="btn btn-default" name="submitPayPalValidation">
						
					{l s='Get payment status' mod='paypal'}
					</button>
				</p>
			</form>
		</div>
	</div>
</div>
{else}
<br />
<fieldset {if isset($ps_version) && ($ps_version < '1.5')}style="width: 400px"{/if}>
	<legend><img src="{$base_url|escape:'htmlall':'UTF-8'}modules/{$module_name|escape:'htmlall':'UTF-8'}/{if $order_payment == 'paypal'}logo.gif{else}views/img/braintree.png{/if}" alt="" />{if $order_payment == 'paypal'}{l s='PayPal Validation' mod='paypal'}{else}{l s='Braintree Validation' mod='paypal'}{/if}</legend>
	<p><b>{l s='Information:' mod='paypal'}</b> {if $order_state == $authorization}{l s='Pending Capture - No shipping' mod='paypal'}{else}{l s='Pending Payment - No shipping' mod='paypal'}{/if}</p>
	<form method="post" action="{$smarty.server.REQUEST_URI|escape:'htmlall':'UTF-8'}">
		<input type="hidden" name="id_order" value="{$params.id_order|intval}" />
		<p class="center"><input type="submit" class="button" name="submitPayPalValidation" value="{l s='Get payment status' mod='paypal'}" /></p>
	</form>
</fieldset>
{/if}


