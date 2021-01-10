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


{*Displaying a button or the iframe*}
<div id="ppplus"></div>

{literal}
<script type="application/javascript">

    var ppp = PAYPAL.apps.PPP({
        "approvalUrl": "{/literal}{$approval_url|escape:'htmlall':'UTF-8'}{literal}",
        "placeholder": "ppplus",
        "mode": "{/literal}{$mode|escape:'htmlall':'UTF-8'}{literal}",
        {/literal}{if $mode == 'sandbox'}"showPuiOnSandbox": true,{/if}{literal}
        "language": "{/literal}{$language|escape:'htmlall':'UTF-8'}{literal}",
        "country": "{/literal}{$country|escape:'htmlall':'UTF-8'}{literal}",
        "onContinue" : function () {
                        doPatch(ppp);
        }
    });

    function doPatch(ppp) {
        jQuery.ajax({
            url : "{/literal}{$ajaxUrl|escape:'javascript':'UTF-8'}{literal}",
            complete: function(){
                ppp.doCheckout();
            }

        });
    }
</script>
{/literal}
