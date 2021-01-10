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
*  @license	http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

{if isset($showWarningForBraintreeUsers) && $showWarningForBraintreeUsers}
    <div class="bootstrap">
        <div class="bootstrap alert alert-warning">
            {l s='Note: the new version of the module (v3.14.0) requires to add your credentials details if you need to change your account settings.' mod='paypal'}
        </div>
    </div>
{/if}

<p>
    {l s='To find your API Keys, please follow those steps:' mod='paypal'}
</p>
<ul>
    <li>
        {{l s='Log into your [a @href1@]account[/a]' mod='paypal'}|paypalreplace:['@href1@' => {'https://www.braintreegateway.com/login'}, '@target@' => {'target="blank"'}]}
    </li>
    <li>
        {l s='Click on Parameters (the working wheel logo)' mod='paypal'}
    </li>
    <li>
        {l s='Click on API' mod='paypal'}
    </li>
    <li>
        {l s='Click the "Generate New API Key"' mod='paypal'}
    </li>
    <li>
        {l s='Click on "View" in the "Private key" column' mod='paypal'}
    </li>
    <li>
        {l s='Copy your "Private Key", "Public Key" and "Merchant ID" and paste them below:' mod='paypal'}
    </li>
</ul>

<p>
    {{l s='To retrieve sandbox API Keys please repeat the steps by connecting to [a @href1@]sandbox account[/a] or creating a new [a @href2@]one[/a]' mod='paypal'}|paypalreplace:['@href1@' => {'https://sandbox.braintreegateway.com/login'}, '@href2@' => {'https://www.braintreepayments.com/sandbox'},  '@target@' => {'target="blank"'}]}
</p>

<div class="bootstrap paypal-mt-20">
    <div>
        <button class="btn btn-default" type="button" data-role-collapse data-collapsed="#apiHelpMessage">
            {l s='Impossible to access to API via Braintree account?' mod='paypal'}
        </button>

        <div id="apiHelpMessage" class="alert alert-info paypal-mt-20" style="display: none">
            <div>
                <p>
                    {{l s='If you get an error message "[b]You do not have the proper authorization for this request[/b]" when you access to your API keys via your Braintree account:' mod='paypal'}|paypalreplace}
                </p>

                <p class="paypal-mt-20">
                    {{l s='[b]Your account was already configured:[/b]' mod='paypal'}|paypalreplace}
                </p>

                <p>
                    {l s='- You are able to use your API keys if you stored them previously and to continue to accept payments via Braintree if your account is already correctly configurated. No actions required on your side.' mod='paypal'}
                </p>

                <p>
                    {{l s='[b]You would like to change your account configurations but your can not get your API keys:[/b]' mod='paypal'}|paypalreplace}
                </p>

                <p>
                    {l s='- If you have not stored your API keys somewhere on your side, you will no longer be able to use your current account API credentials as we can\'t provide them for you. If you would like to continue using your current PrestaShop Braintree module which requires API keys, you will need to apply for a Braintree Direct account by clicking the “Sign up” button at the bottom of Braintree homepage. Once you have been approved for the new account, you will be able to log in and retrieve your API keys. If you have any issues on the approval process by Braintree, please contact Braintree Support on their website.' mod='paypal'}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="paypal-mt-20">
    <div class="h3">{l s='Live' mod='paypal'}</div>
    <hr>
    <dl>
        <dt><label for="paypal_braintree_pub_key_live">{l s='Public key' mod='paypal'} : </label></dt>
        <dd>
            <input
                    type='text' size="85"
                    name="paypal_braintree_pub_key_live"
                    id="paypal_braintree_pub_key_live"
                    value="{if isset($paypal_braintree_pub_key_live)}{$paypal_braintree_pub_key_live|escape:'htmlall':'utf-8'}{/if}"
                    autocomplete="off"
            />
        </dd>

        <dt><label for="paypal_braintree_priv_key_live">{l s='Private key' mod='paypal'} : </label></dt>
        <dd>
            <input
                    type='password'
                    size="85"
                    name="paypal_braintree_priv_key_live"
                    id="paypal_braintree_priv_key_live"
                    value="{if isset($paypal_braintree_priv_key_live)}{$paypal_braintree_priv_key_live|escape:'htmlall':'utf-8'}{/if}"
                    autocomplete="off"
            />
        </dd>

        <dt><label for="paypal_braintree_merchant_id_live">{l s='Merchant ID' mod='paypal'} : </label></dt>
        <dd>
            <input
                    type='text'
                    size="85"
                    name="paypal_braintree_merchant_id_live"
                    id="paypal_braintree_merchant_id_live"
                    value="{if isset($paypal_braintree_merchant_id_live)}{$paypal_braintree_merchant_id_live|escape:'htmlall':'utf-8'}{/if}"
                    autocomplete="off"
            />
        </dd>
    </dl>
</div>

<div class="paypal-clear"></div>

<div>
    <div class="h3">{l s='Sandbox' mod='paypal'}</div>
    <hr>

    <dl>
        <dt><label for="paypal_braintree_pub_key_sandbox">{l s='Public key' mod='paypal'} : </label></dt>
        <dd>
            <input
                    type='text' size="85"
                    name="paypal_braintree_pub_key_sandbox"
                    id="paypal_braintree_pub_key_sandbox"
                    value="{if isset($paypal_braintree_pub_key_sandbox)}{$paypal_braintree_pub_key_sandbox|escape:'htmlall':'utf-8'}{/if}"
                    autocomplete="off"
            />
        </dd>

        <dt><label for="paypal_braintree_priv_key_sandbox">{l s='Private key' mod='paypal'} : </label></dt>
        <dd>
            <input
                    type='password'
                    size="85"
                    name="paypal_braintree_priv_key_sandbox"
                    id="paypal_braintree_priv_key_sandbox"
                    value="{if isset($paypal_braintree_priv_key_sandbox)}{$paypal_braintree_priv_key_sandbox|escape:'htmlall':'utf-8'}{/if}"
                    autocomplete="off"
            />
        </dd>

        <dt><label for="paypal_braintree_merchant_id_sandbox">{l s='Merchant ID' mod='paypal'} : </label></dt>
        <dd>
            <input
                    type='text'
                    size="85"
                    name="paypal_braintree_merchant_id_sandbox"
                    id="paypal_braintree_merchant_id_sandbox"
                    value="{if isset($paypal_braintree_merchant_id_sandbox)}{$paypal_braintree_merchant_id_sandbox|escape:'htmlall':'utf-8'}{/if}"
                    autocomplete="off"
            />
        </dd>
    </dl>
</div>

<div class="paypal-clear"></div>