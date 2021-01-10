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



    {capture name=path}{l s='Order confirmation' mod='paypal'}{/capture}
    {if $smarty.const._PS_VERSION_ < 1.6}
        {include file="$tpl_dir./breadcrumb.tpl"}
    {/if}
    <h1>{l s='Order confirmation' mod='paypal'}</h1>

    {assign var='current_step' value='payment'}
    {include file="$tpl_dir./order-steps.tpl"}

    {include file="$tpl_dir./errors.tpl"}

    {$HOOK_ORDER_CONFIRMATION}
    {$HOOK_PAYMENT_RETURN}

    <br />

    {if $order}
        <p><b>{l s='Your order is waiting for validation by PayPal' mod='paypal'}</b></p>
        <p>{l s='Total of the transaction (taxes incl.) :' mod='paypal'} <span class="paypal-bold">{$price|escape:'htmlall':'UTF-8'}</span></p>
        <p>{l s='Your order ID is :' mod='paypal'}
            <span class="paypal-bold">
		{if $smarty.const._PS_VERSION_ >= 1.5}
            {if isset($order->reference)}
                {$order->reference|escape:'htmlall':'UTF-8'}
            {else}
                {$order->id_order|intval}
            {/if}
        {else}
            {$order->id_order|intval}
        {/if}
		</span>
        </p>
    {/if}
    <br />

    {if $is_guest}
        <a href="{$link->getPageLink('guest-tracking.php', true)|escape:'htmlall':'UTF-8'}?id_order={$order.reference|escape:'htmlall':'UTF-8'}" title="{l s='Follow my order' mod='paypal'}" data-ajax="false">
            {if $smarty.const._PS_VERSION_ < 1.6}
                <img src="{$img_dir|escape:'htmlall':'UTF-8'}icon/order.gif" alt="{l s='Follow my order' mod='paypal'}" class="icon" />
            {else}
                <i class="icon-chevron-left"></i>
            {/if}
        </a>
        <a href="{$link->getPageLink('guest-tracking.php', true)|escape:'htmlall':'UTF-8'}?id_order={$order.reference|escape:'htmlall':'UTF-8'}" title="{l s='Follow my order' mod='paypal'}" data-ajax="false">{l s='Follow my order' mod='paypal'}</a>
    {else}
        <a href="{$link->getPageLink('history.php', true)|escape:'htmlall':'UTF-8'}" title="{l s='Back to orders' mod='paypal'}" data-ajax="false">{if $smarty.const._PS_VERSION_ < 1.6}
                <img src="{$img_dir|escape:'htmlall':'UTF-8'}icon/order.gif" alt="{l s='Follow my order' mod='paypal'}" class="icon" />
            {else}
                <i class="icon-chevron-left"></i>
            {/if}</a>
        <a href="{$link->getPageLink('history.php', true)|escape:'htmlall':'UTF-8'}" title="{l s='Back to orders' mod='paypal'}" data-ajax="false">{l s='Back to orders' mod='paypal'}</a>
    {/if}

