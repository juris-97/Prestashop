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

{if $smarty.const._PS_VERSION_ < 1.5 && isset($use_mobile) && $use_mobile}
	{include file="$tpl_dir./modules/paypal/views/templates/front/error.tpl"}
{else}
	{capture name=path}<a href="order.php">{l s='Your shopping cart' mod='paypal'}</a><span class="navigation-pipe"> {$navigationPipe|escape:'htmlall':'UTF-8'} </span> {l s='PayPal' mod='paypal'}{/capture}
	{include file="$tpl_dir./breadcrumb.tpl"}

	<h2>{$message|escape:'htmlall':'UTF-8'}</h2>
	{if isset($logs) && $logs}
		<div class="error">
			<p><b>{l s='Please try to contact the merchant:' mod='paypal'}</b></p>
			
			<ol>
			{foreach from=$logs key=key item=log}
				<li>{$log|escape:'htmlall':'UTF-8'}</li>
			{/foreach}
			</ol>
			
			<br>	
			
			{if isset($order)}
				<p>
					{l s='Total of the transaction (taxes incl.) :' mod='paypal'} <span class="paypal-bold">{$price|escape:'htmlall':'UTF-8'}</span><br>
					{l s='Your order ID is :' mod='paypal'} <span class="paypal-bold">{$order.id_order|intval}</span><br>
				</p>
			{/if}
			
			<p><a href="{$base_dir|escape:'htmlall':'UTF-8'}" class="button_small" title="{l s='Back' mod='paypal'}">&laquo; {l s='Back' mod='paypal'}</a></p>
		</div>
	
	{/if}

{/if}
