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

<div class="bootstrap">

	{if $showPsCheckoutInfo}
		<div class="alert alert-info ps-checkout-info">
			<button type="button" class="close" data-dismiss="alert" data-action="close">×</button>
			{{l s='This module allows your customers to pay with their PayPal account. If you wish to accept credit cards and other payment methods in addition to PayPal, we recommend the [a @href1@]PrestaShop Checkout[/a] module.' mod='paypal'}|paypalreplace:['@href1@' => {'#'}, '@target@' => {'data-action="install"'}]}
		</div>
	{/if}

	{if $PayPal_payment_method == $PayPal_ECS}
		<div class="alert alert-info">
			<p>
				{l s='The PayPal Integral payment experience offers today the same conversion, security and simplicity benefits as Option +. So we have merge these options within the module.' mod='paypal'}
			</p>
		</div>
	{/if}

	{if $PayPal_payment_method == $PayPal_HSS}
		<div class="alert alert-info">
			<p>
				{l s='HSS is not supported by PayPal anymore (but for the moment the payments by PayPal work correctly)' mod='paypal'}
			</p>

			<ul>
				<li>
					{l s='What to do? (Recommended) Install PrestaShop Checkout. Or you can still use PayPal standard even if it’s deprecated.' mod='paypal'}
				</li>

				<li>
					{l s='How to cancel HSS subscription?' mod='paypal'}
					<a href="https://www.paypal.com/us/smarthelp/article/how-do-i-cancel-a-billing-agreement,-automatic-recurring-payment-or-subscription-faq2254"
						target="_blank">
						https://www.paypal.com/us/smarthelp/article/how-do-i-cancel-a-billing-agreement,-automatic-recurring-payment-or-subscription-faq2254
					</a>
				</li>
			</ul>
		</div>

		{if $PayPal_WPS_is_configured}
			<div class = "alert alert-info">
				<p>
					{l s='You have already configured the PayPal Standard payment solution. In order to enable it please verify if all the settings are correct and save them again.' mod='paypal'}
				</p>
			</div>
		{/if}

		<div class="alert alert-info">
			{l s='The PayPal Integral payment experience offers today the same conversion, security and simplicity benefits as Option +. So we have merge these options within the module.' mod='paypal'}
		</div>
	{/if}

</div>


<div id="paypal-wrapper">
	{if !empty($hss_errors)}
        <div style="background-color: red; color: white; font-weight: bolder; padding: 5px; margin-top: 10px;">
            {l s='Orders for following carts (id) could not be created because of email error' mod='paypal'}
            {foreach from=$hss_errors item=hss}
                <p><span style="background-color: black; padding: 5px;">{$hss.id_cart|escape:'htmlall':'UTF-8'} - {$hss.email|escape:'htmlall':'UTF-8'}</span></p>
            {/foreach}
            {l s='You must change the e-mail in the module configuration with the one displayed above' mod='paypal'}
        </div>
	{/if}
	{* PayPal configuration page header *}
	<div class="box half left">
		<img src="{$moduleDir|addslashes}/views/img/logos/PP_Horizontal_rgb_2016.png" alt="" style="margin-bottom: -5px; max-height: 50px;" />
		<p id="paypal-slogan"><span class="dark">{l s='Leader in' mod='paypal'}</span> <span class="light">{l s='online payments' mod='paypal'}</span></p>
		<p>{l s='Easy, secure, fast payments for your buyers.' mod='paypal'}</p>
	</div>

	<div class="box half right">
		<ul class="tick">
            <li><span class="paypal-bold">{l s='Get more buyers' mod='paypal'}</span><br />{l s='300 million-plus PayPal accounts worldwide' mod='paypal'}</li>
            <li><span class="paypal-bold">{l s='Access international buyers' mod='paypal'}</span><br />{l s='190 countries, 25 currencies' mod='paypal'}</li>
            <li><span class="paypal-bold">{l s='Reassure your buyers' mod='paypal'}</span><br />{l s='Buyers don\'t need to share their private data' mod='paypal'}</li>
            <li><span class="paypal-bold">{l s='Accept all major payment method' mod='paypal'}</span></li>
        </ul>
	</div>

	<div class="paypal-clear"></div>


	{if $PayPal_allowed_methods}
		<div class="paypal-clear"></div><hr>

		<form method="post" action="{$smarty.server.REQUEST_URI|escape:'htmlall':'UTF-8'}" id="paypal_configuration">
			{* PayPal configuration blocks *}
			<div class="box">
				<h3 class="inline">{l s='Getting started with PayPal only takes 5 minutes' mod='paypal'}</h3>
				<div style="line-height: 20px; margin-top: 8px">
					<div>
						<label>{l s='Your country' mod='paypal'} :
							{$PayPal_country|escape:'htmlall':'UTF-8'}
						</label>
					</div>

					<label>{l s='You already have a PayPal business account' mod='paypal'} ?</label>
					<input type="radio" name="business" id="paypal_business_account_no" value="0" {if $PayPal_business == 0}checked="checked"{/if} /> <label for="paypal_business_account_no">{l s='No' mod='paypal'}</label>
					<input type="radio" name="business" id="paypal_business_account_yes" value="1" style="margin-left: 14px" {if $PayPal_business == 1}checked="checked"{/if} /> <label for="paypal_business_account_yes">{l s='Yes' mod='paypal'}</label>
				</div>
			</div>

			<div class="paypal-clear"></div><hr />

			{* END OF USE PAYPAL LOGIN *}

			{* SUBSCRIBE OR OPEN YOUR PAYPAL BUSINESS ACCOUNT *}
			<div data-open-account-section class="box" id="account">

				<h3 class="inline">{l s='Apply or open your PayPal Business account' mod='paypal'}</h3>

				<br /><br />

				<div id="signup">
					{* Use cases 1 - 3 *}
					<a href="{l s='https://www.paypal.com/bizsignup' mod='paypal'}" target="_blank" class="paypal-button paypal-signup-button" id="paypal-signup-button-u1">{l s='Sign Up' mod='paypal'}</a>

					<a href="{l s='https://www.paypal.com/bizsignup' mod='paypal'}" target="_blank" class="paypal-button paypal-signup-button" id="paypal-signup-button-u3">{l s='Sign Up' mod='paypal'}</a>

					{* Use cases 4 - 6 *}
					<a href="{l s='https://www.paypal.com/bizsignup' mod='paypal'}#" target="_blank" class="paypal-button paypal-signup-button" id="paypal-signup-button-u5">{l s='Subscribe' mod='paypal'}</a>

					<br /><br />

					{* Use cases 1 - 3 *}
					<span class="paypal-signup-content" id="paypal-signup-content-u1">{l s='Once your account is created, come back to this page in order to complete the setup of the module.' mod='paypal'}</span>

					<span class="paypal-signup-content" id="paypal-signup-content-u3">{l s='Once your account is created, come back to this page in order to complete the setup of the module.' mod='paypal'}</span>

					{* Use cases 4 - 6 *}
					<span class="paypal-signup-content" id="paypal-signup-content-u5">{l s='Click on the SAVE button only when PayPal has approved your subscription for this product, otherwise you won\'t be able to process payment. This process can take up to 3-5 days.' mod='paypal'}<br/>
                    {l s='If your application for Website Payments Pro has already been approved by PayPal, please go directly to step 3' mod='paypal'}.</span>

				</div>

				<hr />

			</div>

			{* ENABLE YOUR ONLINE SHOP TO PROCESS PAYMENT *}
			<div data-configuration-section class="box paypal-disabled" id="credentials">

				<div class="right half" id="paypal-call-button">
					<div id="paypal-call" class="box right"><span style="font-weight: bold">{l s='Need help ?' mod='paypal'}</span> <a target="_blank" href="https://www.paypal.com/webapps/mpp/contact-us">{l s='Contact us' mod='paypal'}</a></div>
				</div>

				<h3 class="inline">{l s='CONFIGURE YOUR PAYMENT SOLUTION' mod='paypal'}</h3>
				<br /><br />

				{* Start of a section of a choise of a payment mode *}

				{if (in_array($PayPal_WPS, $PayPal_allowed_methods))}

					<div class="paypal-clear"></div>
					<div class="form-block">
						{if (in_array($PayPal_WPS, $PayPal_allowed_methods))}
							{* WEBSITE PAYMENT STANDARD *}
							<label for="paypal_payment_wps" class="flex-display">
								<div>
									<input
											type="radio"
											name="paypal_payment_method"
											id="paypal_payment_wps"
											value='{$PayPal_WPS|escape:'htmlall':'UTF-8'}'
											{if (in_array($PayPal_PPP, $PayPal_allowed_methods) == false)}style="display: none"{/if}
											{if in_array($PayPal_payment_method, [$PayPal_WPS, $PayPal_HSS, $PayPal_ECS])}checked="checked"{/if} />
								</div>
								<div>
									<div class="bold size-l">
										{l s='Website Payments Standard' mod='paypal'}
									</div>
									<div class="description">
										<div>{l s='Start accepting payments immediately.' mod='paypal'}</div>
										<div>{l s='No subscription fees, pay only when you get paid.' mod='paypal'}</div>
									</div>


								</div>
							</label>
						{/if}
						<div class="paypal-clear"></div>


						<div class="paypal-clear"></div>
						{if (in_array($PayPal_PPP, $PayPal_allowed_methods))}
							{* WEBSITE PAYMENT PLUS *}
							<br />
							<label for="paypal_payment_ppp">
								<input type="radio" name="paypal_payment_method" id="paypal_payment_ppp" value='{$PayPal_PPP|escape:'htmlall':'UTF-8'}' {if $PayPal_payment_method == $PayPal_PPP}checked="checked"{/if} />
								<span class="bold size-l">{l s='Choose' mod='paypal'} {l s='PayPal Plus' mod='paypal'}</span><br />
								<span class="description"></span>
							</label>
						{/if}
					</div>
				{/if}
				<div class="paypal-clear"></div>

				{* End of a section of a choise of a payment mode *}

				<div class="paypal-hide" id="configuration">
					{* Credentials *}

					<div id="standard-credentials">
						<h4>{l s='Communicate your PayPal identification info to PrestaShop' mod='paypal'}</h4>

						<br />

						<a href="#" class="paypal-button" id="paypal-get-identification">
						{l s='Get my PayPal identification info' mod='paypal'}<p class="toolbox">{l s='After clicking on the “Get my PayPal identification info” button, enter your login and password in the pop up, copy your PayPal identification info from the pop up and paste them is the below fields.' mod='paypal'}</p>
						</a>

						<br /><br />

						<dl>
							<dt><label for="api_username">{l s='API username' mod='paypal'} : </label></dt>
							<dd><input type='text' name="api_username" id="api_username" value="{$PayPal_api_username|escape:'html':'UTF-8'}" autocomplete="off" size="85"/></dd>
							<dt><label for="api_password">{l s='API password' mod='paypal'} : </label></dt>
							<dd><input type='password' size="85" name="api_password" id="api_password" value="{$PayPal_api_password|escape:'html':'UTF-8'}" autocomplete="off" /></dd>
							<dt><label for="api_signature">{l s='API signature' mod='paypal'} : </label></dt>
							<dd><input type='text' size="85" name="api_signature" id="api_signature" value="{$PayPal_api_signature|escape:'html':'UTF-8'}" autocomplete="off" /></dd>
						</dl>
						<div class="paypal-clear"></div>
						<span class="description">{l s='Please check once more that you pasted all the characters.' mod='paypal'}</span>
					</div>

					<div id="paypalplus-credentials">
						<h4>{l s='Provide your PayPal API credentials to PrestaShop' mod='paypal'}</h4>

						<br />

						<dl>
							<dt><label for="client_id">{l s='Client ID' mod='paypal'} : </label></dt>
							<dd><input type='text' name="client_id" id="client_id" value="{$PayPal_plus_client|escape:'html':'UTF-8'}" autocomplete="off" size="85"/></dd>
							<dt><label for="secret">{l s='Secret' mod='paypal'} : </label></dt>
							<dd><input type='password' size="85" name="secret" id="secret" value="{$PayPal_plus_secret|escape:'html':'UTF-8'}" autocomplete="off" /></dd>

							<dt><label for="webprofile">{l s='Use personnalisation (uses your logo and your shop name on Paypal) :' mod='paypal'}</label></dt>
							<dd>
								<input type="radio" name="paypalplus_webprofile" value="1" id="paypal_plus_webprofile_yes" {if $PayPal_plus_webprofile}checked="checked"{/if} /> <label for="paypal_plus_webprofile_yes">{l s='Yes' mod='paypal'}</label><br />
								<input type="radio" name="paypalplus_webprofile"  value="0" id="paypal_plus_webprofile_no" {if $PayPal_plus_webprofile == '0'}checked="checked"{/if} /> <label for="paypal_plus_webprofile_no">{l s='No' mod='paypal'}</label>
							</dd>
						</dl>
						<div class="paypal-clear"></div>
					</div>


					<div class="paypal-clear"></div>

					<h4>{l s='To finalize setting up your PayPal account, you need to' mod='paypal'} : </h4>
					<p><span class="paypal-bold">1.</span> {l s='Confirm your email address : check the email sent by PayPal when you created your account' mod='paypal'}</p>
					<p><span class="paypal-bold">2.</span> {l s='Link your PayPal account to a bank account or a credit card : log into your PayPal account and go to "My business setup"' mod='paypal'}</p>

					<h4>{l s='Configuration options' mod='paypal'}</h4>

					<div id="express_checkout_shortcut" class="paypal-hide">
						<p>{l s='Use express checkout shortcut' mod='paypal'}</p>
						<p class="description">{l s='Offer your customers a 2-click payment option' mod='paypal'}</p>
						<input type="radio" name="express_checkout_shortcut" id="paypal_payment_ecs_no_shortcut" value="1" {if $PayPal_express_checkout_shortcut == 1}checked="checked"{/if} /> <label for="paypal_payment_ecs_no_shortcut">{l s='Yes' mod='paypal'} (recommanded)</label><br />
						<input type="radio" name="express_checkout_shortcut" id="paypal_payment_ecs_shortcut" value="0" {if $PayPal_express_checkout_shortcut == 0}checked="checked"{/if} /> <label for="paypal_payment_ecs_shortcut">{l s='No' mod='paypal'}</label>
						<p class="merchant_id">
							<label>{l s='Merchant ID' mod='paypal'}</label>
							<input type="text" name="in_context_checkout_merchant_id" id="in_context_checkout_merchant_id" value="{if isset($PayPal_in_context_checkout_merchant_id) && $PayPal_in_context_checkout_merchant_id != ""}{$PayPal_in_context_checkout_merchant_id|escape:'htmlall':'UTF-8'}{/if}" />
							<p class="description">{l s='You can find your merchant account ID under "Account options" in your PayPal account Settings' mod='paypal'}</p>
						</p>
					</div>

					<div id="in_context_checkout" class="paypal-hide">
						<p>{l s='Use PayPal In Context Checkout' mod='paypal'}</p>
						<p class="description">{l s='Make your client pay without leaving your website' mod='paypal'}</p>
						<input type="radio" name="in_context_checkout" id="paypal_payment_ecs_no_in_context_checkout" value="1" {if $PayPal_in_context_checkout == 1}checked="checked"{/if} /> <label for="paypal_payment_ecs_no_in_context_checkout">{l s='Yes' mod='paypal'}</label><br />
						<input type="radio" name="in_context_checkout" id="paypal_payment_ecs_in_context_checkout" value="0" {if $PayPal_in_context_checkout == 0}checked="checked"{/if} /> <label for="paypal_payment_ecs_in_context_checkout">{l s='No' mod='paypal'}</label>
					</div>

					<div>
						<p>{l s='Use the PayPal Login functionnality' mod='paypal'}</p>
						<p class="description">
							{l s='This function allows to your clients to connect with their PayPal credentials to shorten the check out' mod='paypal'}
						</p>
						<div id="paypal_login_yes_or_no" class="">
							<p class="description"></p>
							<input type="radio" name="paypal_login" id="paypal_login_yes" value="1" {if $PayPal_login == 1}checked="checked"{/if} /> <label for="paypal_login_yes">{l s='Yes' mod='paypal'} </label><br />
							<input type="radio" name="paypal_login" id="paypal_login_no" value="0" {if $PayPal_login == 0}checked="checked"{/if} /> <label for="paypal_login_no">{l s='No' mod='paypal'}</label>
						</div>
						<div id="paypal_login_configuration"{if $PayPal_login == 0} style="display: none;"{/if}>
							<p>
								{l s='Fill in the informations of your PayPal account' mod='paypal'}.{if $default_lang_iso == 'fr'}(* {l s='See' mod='paypal'} <a href="http://altfarm.mediaplex.com/ad/ck/3484-197941-8030-96">{l s='Integration Guide' mod='paypal'}</a>){/if}.
							</p>
							<dl>
								<dt>
									{l s='Client ID' mod='paypal'}
								</dt>
								<dd>
									<input type="text" name="paypal_login_client_id" value="{$PayPal_login_client_id|escape:'htmlall':'UTF-8'}" autocomplete="off" size="85">
								</dd>
								<dt>
									{l s='Secret' mod='paypal'}
								</dt>
								<dd>
									<input type="text" name="paypal_login_client_secret" value="{$PayPal_login_secret|escape:'htmlall':'UTF-8'}" autocomplete="off" size="85">
								</dd>

								<dt>
									{l s='Choose your template' mod='paypal'}
									<p class="description" style="margin-top:-10px;">({l s='Translated in your language' mod='paypal'})</p>
								</dt>
								<dd>
									<input type="radio" name="paypal_login_client_template" id="paypal_login_client_template_paypal_blue" value="1"{if $PayPal_login_tpl == 1} checked{/if} />
									<label for="paypal_login_client_template_paypal_blue">
										<img src="../modules/paypal/views/img/paypal_login_blue.png" alt="">
									</label>
									<br />
									<input type="radio" name="paypal_login_client_template" id="paypal_login_client_template_neutral" value="2"{if $PayPal_login_tpl == 2} checked{/if} />
									<label for="paypal_login_client_template_neutral">
										<img src="../modules/paypal/views/img/paypal_login_grey.png" alt="">
									</label>
								</dd>
							</dl>


							<div class="paypal-clear"></div>
						</div>
					</div>


					<p>{l s='Use Sand box' mod='paypal'}</p>
					<p class="description">{l s='Activate a test environment in your PayPal account (only if you are a developer).' mod='paypal'} <a href="{l s='https://developer.paypal.com/' mod='paypal'}" target="_blank">{l s='Learn more' mod='paypal'}</a></p>
					<input type="radio" name="sandbox_mode" id="paypal_payment_live_mode" value="0" {if $PayPal_sandbox_mode == 0}checked="checked"{/if} /> <label for="paypal_payment_live_mode">{l s='Live mode' mod='paypal'}</label><br />
					<input type="radio" name="sandbox_mode" id="paypal_payment_test_mode" value="1" {if $PayPal_sandbox_mode == 1}checked="checked"{/if} /> <label for="paypal_payment_test_mode">{l s='Test mode' mod='paypal'}</label>

					<br />

					<p>{l s='Payment type' mod='paypal'}</p>
					<p class="description">{l s='Choose your way of processing payments (automatically vs.manual authorization).' mod='paypal'}</p>
					<input type="radio" name="payment_capture" id="paypal_direct_sale" value="0" {if $PayPal_payment_capture == 0}checked="checked"{/if} /> <label for="paypal_direct_sale">{l s='Direct sales (recommended)' mod='paypal'}</label><br />
					<input type="radio" name="payment_capture" id="paypal_manual_capture" value="1" {if $PayPal_payment_capture == 1}checked="checked"{/if} /> <label for="paypal_manual_capture">{l s='Authorization/Manual capture (payment shipping)' mod='paypal'}</label>

					<div class="clear"></div>

				</div>

				<br><br>

				{* Start Braintree section*}

				{if (in_array($PayPal_PVZ, $PayPal_allowed_methods))}
					{if version_compare($smarty.const.PHP_VERSION, '5.4.0', '<')}
						<strong class="braintree_title_bo">{l s='Want to use Braintree as card processor ?' mod='paypal'}</strong> &nbsp;<a href="{l s='https://www.braintreepayments.com/' mod='paypal'}" target="_blank" class="braintree_link"><img src="{$PayPal_module_dir|escape:'htmlall':'UTF-8'}/views/img/logos/BRAINTREE.png" class="braintree_logo"> &nbsp;&nbsp;&nbsp;<div class="bo_paypal_help">?</div></a><br/>
						<p id="error_version_php">{l s='You can\'t use braintree because your PHP version is too old (PHP 5.4 min)' mod='paypal'}</p>
					{elseif !$ps_ssl_active}
						<strong class="braintree_title_bo">{l s='Want to use Braintree as card processor ?' mod='paypal'}</strong> &nbsp;<a href="{l s='https://www.braintreepayments.com/' mod='paypal'}" target="_blank" class="braintree_link"><img src="{$PayPal_module_dir|escape:'htmlall':'UTF-8'}/views/img/logos/BRAINTREE.png" class="braintree_logo"> &nbsp;&nbsp;&nbsp;<div class="bo_paypal_help">?</div></a><br/>
						<p id="error_version_php">{l s='You can\'t use braintree because you haven\'t enabled https' mod='paypal'}</p>
					{else}
						{* WEBSITE PAYMENT PLUS *}
						<br />
						<strong class="braintree_title_bo">{l s='Want to use Braintree as card processor ?' mod='paypal'} {l s='(Euro only)' mod='paypal'}</strong> &nbsp;<a href="{l s='https://www.braintreepayments.com/' mod='paypal'}" target="_blank" class="braintree_link"><img src="{$PayPal_module_dir|escape:'htmlall':'UTF-8'}/views/img/logos/BRAINTREE.png" class="braintree_logo"> &nbsp;&nbsp;&nbsp;<div class="bo_paypal_help">?</div></a><br/>

						<label for="braintree_enabled">
							<input type="checkbox" name="braintree_enabled" id="braintree_enabled" value='{$PayPal_PVZ|escape:'htmlall':'UTF-8'}' {if $PayPal_braintree_enabled}checked="checked"{/if} />
							{l s='Choose' mod='paypal'} {l s='Braintree' mod='paypal'}<br />
							<span class="description"></span>
							<!-- <p class="toolbox"></p> -->
						</label>
						<span id="braintree_message" style="{$Braintree_Style|escape:'htmlall':'UTF-8'}">{$Braintree_Message|escape:'htmlall':'UTF-8'}</span>
						<div id="paypal_braintree">
							<div>
								{include './sectionBraintreeCredentials.tpl'}
							</div>

							<div class="bootstrap">
								<div class="alert alert-info">
									<p>
										{l s='Note : As part of European Regulation PSD2 and related SCA (Strong Customer Authentication) planned on September 14th 2019, all transactions will have to go through SCA (3DS 2.0) with the aim to reduce friction (fewer “client challenges”) while raise conversion and protection (more liability shifts from merchant to bank).' mod='paypal'}
									</p>

									<p>
										{l s='It is thus recommended to enable 3D Secure in order to avoid bank declines and impact to your business.' mod='paypal'}
									</p>

									<p>
										{{l s='More info in our blog post [b]to get the last updates:[/b]' mod='paypal'}|paypalreplace}
										<a href="https://www.braintreepayments.com/ie/features/3d-secure">
											https://www.braintreepayments.com/ie/features/3d-secure
										</a>
									</p>
								</div>
							</div>


							<div>
								{include './button_braintree.tpl'}
							</div>
						</div>
					{/if}
				{/if}

				{* End Braintree section*}

				<br /><br />

				<input type="hidden" name="submitPaypal" value="paypal_configuration" />
				<input type="submit" name="submitButton" value="{l s='Save' mod='paypal'}" id="paypal_submit" />

				<div class="box paypal-hide" id="paypal-test-mode-confirmation">
					<h3>{l s='Activating the test mode implies that' mod='paypal'} :</h3>
					<ul>
						<li>{l s='You won\'t be able to accept payment' mod='paypal'}</li>
                        <li>{l s='You will need to come back to the PayPal module page in order to complete the Step 3 before going live.' mod='paypal'}</li>
                        <li>{l s='You\'ll need to create an account on the PayPal sandbox site' mod='paypal'} (<a href="https://developer.paypal.com/" target="_blank">{l s='learn more' mod='paypal'}</a>)</li>
                        <li>{l s='You\'ll need programming skills' mod='paypal'}</li>
					</ul>

					<h4>{l s='Are you sure you want to activate the test mode ?' mod='paypal'}</h4>

					<div id="buttons">
						<button class="sandbox_confirm" value="0">{l s='No' mod='paypal'}</button>
						<button class="sandbox_confirm" value="1">{l s='Yes' mod='paypal'}</button>
					</div>
				</div>

				{if isset($PayPal_save_success)}
				<div class="box paypal-hide" id="paypal-save-success">
					<h3>{l s='Congratulation !' mod='paypal'}</h3>
					{if $PayPal_sandbox_mode == 0}
					<p>{l s='You can now start accepting Payment  with PayPal.' mod='paypal'}</p>
					{elseif  $PayPal_sandbox_mode == 1}
					<p>{l s='You can now start testing PayPal solutions. Don\'t forget to comeback to this page and activate the live mode in order to start accepting payements.' mod='paypal'}</p>
					{/if}
				</div>
				{/if}

				<div class="box paypal-hide" id="js-paypal-save-failure">
					<h3>{l s='Error !' mod='paypal'}</h3>
					<p>{l s='You need to complete the PayPal identification Information in step 4 otherwise you won\'t be able to accept payment.' mod='paypal'}</p>
				</div>

				<hr />
			</div>

			{* TEST FOR CURL*}
			<div data-tls-check-section>
				<h3 class="inline">{l s='Test TLS & curl' mod='paypal'}</h3>
				<br /><br />
				<input type="hidden" id="security_token" value="{$smarty.get.token}" >
				<span style="cursor: pointer;display: inline-block;" id="test_ssl_submit"><b>{l s='Test' mod='paypal'}</b></span>
				<div style="margin-top: 10px;" id="test_ssl_result"></div>
			</div>

		</form>

    {else}
		<div class="paypal-clear"></div><hr />
			<div class="box">
				<p>{l s='Your country is not available for this module please go on Prestashop addons to see the different possibilities.' mod='paypal'}</p>
			</div>
			<hr />
		</div>

	{/if}

</div>
<script>
	var tlscurltest_url = '{$tls_link_ajax|addslashes}';
</script>
