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

$(document).ready(function () {
    var identificationButtonClicked = false;

    var jquery_version = $.fn.jquery.split('.');

    if(jquery_version[0]>=1 && jquery_version[1] >=7) {
        $('#braintree_enabled').on('change', displayConfigurationBraintree );
    } else {
        $('#braintree_enabled').change( displayConfigurationBraintree );
    }

    $(document).on('click', '[data-role-collapse]', function (e) {
        var collapsedElId = $(e.target).attr('data-collapsed');
        $(collapsedElId).slideToggle();
    });

    // Handle click on "Install Prestashop Checkout" button
    $('.ps-checkout-info').on('click', function(e) {
        var action = e.target.getAttribute('data-action');
        psCheckoutHandleAction(action);
    });

    function psCheckoutHandleAction(action) {
        if (action != null) {
            $.ajax({
                url: ajaxHandler,
                type: 'POST',
                data: {
                    ajax: true,
                    action: 'HandlePsCheckoutAction',
                    actionHandled: action,
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.redirect) {
                        window.open(response.url, '_blank');
                    }
                },
            });
        }
    }

    function displayConfigurationBraintree()
    {
        if($('#braintree_enabled:checked').val())
        {
            $('#paypal_braintree').show();
        }
        else
        {
            $('#paypal_braintree').hide();
        }
    }

    displayConfigurationBraintree();

    /* Display correct block according to different choices. */
    function displayConfiguration() {
        identificationButtonClicked = false;
        var paypal_business = $('input[name="business"]:checked').val();
        var paypal_payment_method = $('input[name="paypal_payment_method"]:checked').val();
        var integral_evolution_solution = $('input[name="integral_evolution_solution"]:checked').val();
        var braintree = $('input[name="paypal_payment_pvz"]:checked').val();
        $('#signup span.paypal-signup-content').hide();
        $('#signup .paypal-signup-button').hide();

        switch (paypal_business) {
            case '0':
                $('input[type="submit"]').attr('disabled', 'disabled');

                PaypalSectionManager.hideConfigurationSection();
                PaypalSectionManager.hideTlsCheckSection();
                PaypalSectionManager.showOpenAccountSection();

                switch (paypal_payment_method) {
                    case PayPal_WPS:
                        $('.toolbox').slideUp();
                        $('#paypalplus-credentials').slideUp();
                        $('#integral-credentials').slideUp();
                        $('#standard-credentials').slideDown();
                        $('#paypal-signup-button-u1').show();
                        $('#paypal-signup-content-u1').show();
                        $('#integral_evolution_solution').slideUp();
                        $('#express_checkout_shortcut').slideDown();
                        $('#in_context_checkout').slideDown();
                        break;
                    case PayPal_PPP:
                        $('#standard-credentials').slideUp();
                        $('#integral-credentials').slideUp();
                        $('#integral_evolution_solution').slideUp();
                        $('#express_checkout_shortcut').slideUp();
                        $('#in_context_checkout').slideUp();
                        $('#paypal-signup-button-u1').show();
                        $('#paypal-signup-content-u1').show();
                        $('#paypalplus-credentials').slideDown();
                        break;
                }
                break;
            case '1':
                $('input[type="submit"]').removeAttr('disabled');

                PaypalSectionManager.showConfigurationSection();
                PaypalSectionManager.showTlsCheckSection();
                PaypalSectionManager.hideOpenAccountSection();

                switch (paypal_payment_method) {
                    case PayPal_WPS:
                        $('#paypalplus-credentials').slideUp();
                        $('#integral-credentials').slideUp();
                        $('#standard-credentials').slideDown();
                        $('#paypal-signup-button-u4').show();
                        $('#integral_evolution_solution').slideUp();
                        $('#express_checkout_shortcut').slideDown();
                        $('#in_context_checkout').slideDown();
                        break;
                    case PayPal_PPP:
                        $('#standard-credentials').slideUp();
                        $('#integral-credentials').slideUp();
                        $('#integral_evolution_solution').slideUp();
                        $('#express_checkout_shortcut').slideUp();
                        $('#in_context_checkout').slideUp();
                        $('#paypal-signup-button-u1').hide();
                        $('#paypal-signup-content-u1').hide();
                        $('#paypalplus-credentials').slideDown();
                        break;
                }
                break;
        }

        displayCredentials();
        return;
    }

    if ($('#paypal-wrapper').length != 0) {
        $('.hide').hide();
        displayConfiguration();
    }

    if ($('input[name="paypal_payment_method"]').length == 1) {
        $('input[name="paypal_payment_method"]').attr('checked', 'checked');
    }

    function displayCredentials() {
        var paypal_business = $('input[name="business"]:checked').val();
        var paypal_payment_method = $('input[name="paypal_payment_method"]:checked').val();

        if (paypal_payment_method != PayPal_HSS) {

            if (paypal_payment_method == PayPal_PPP) {
                $('#paypalplus-credentials').slideDown();
            } else {
                $('#paypalplus-credentials').slideUp();
                $('#credentials').removeClass('paypal-disabled');
                $('#configuration').slideDown();
                $('input[type="submit"]').removeAttr('disabled');
                $('#standard-credentials').slideDown();
                $('#express_checkout_shortcut').slideDown();
                $('#integral-credentials').slideUp();
            }
        }
        else if (paypal_payment_method == PayPal_HSS &&
                ($('input[name="api_business_account"]').val().length > 0)) {
            $('#credentials').removeClass('paypal-disabled');
            $('#configuration').slideDown();
            $('input[type="submit"]').removeAttr('disabled');
            $('#standard-credentials').slideUp();
            $('#express_checkout_shortcut').slideUp();
            $('#integral-credentials').slideDown();
        }
        else if (paypal_business != 1) {
            $('#configuration').slideUp();
        }
    }

    if(jquery_version[0]>=1 && jquery_version[1] >=7) {
        $('input[name="business"], input[name="paypal_payment_method"], input[name="integral_evolution_solution"]').on('change', displayConfiguration );
    } else {
        $('input[name="business"], input[name="paypal_payment_method"], input[name="integral_evolution_solution"]').change( displayConfiguration );
    }

    $('label, a').hover(
        function () {
            $(this).children('.toolbox').show();
        }, function () {
            var id = $(this).attr('for');
            var input = $('input#' + id);

            if ( (!input.is(':checked')) || (($(this).attr('id') == 'paypal-get-identification') &&
                (identificationButtonClicked == false))) {
                $(this).children('.toolbox').hide();
            }
        }
    );

    // Display configuration fields after click on "signup" button
    function displaySignup() {
        var paypal_business = $('input[name="business"]:checked').val();
        var paypal_payment_method = $('input[name="paypal_payment_method"]:checked').val();

        $('#credentials').removeClass('paypal-disabled');
        if ($(this).attr('id') != 'paypal-signup-button-u3')
            $('#account').addClass('paypal-disabled');

        $('#configuration').slideDown();
        if (paypal_payment_method == PayPal_HSS) {
            $('#standard-credentials').slideUp();
            $('#express_checkout_shortcut').slideUp();
            $('#integral-credentials').slideDown();
        } else {
            $('#standard-credentials').slideDown();
            $('#express_checkout_shortcut').slideDown();
            $('#integral-credentials').slideUp();
        }
        $('input[type="submit"]').removeAttr('disabled');

        if ($(this).is('#step3')) {
            return false;
        }
        return true;
    }

    if(jquery_version[0]>=1 && jquery_version[1] >= 7) {
        $('a.paypal-signup-button, a#step3').on('click', displaySignup);
    } else {
        $('a.paypal-signup-button, a#step3').click( displaySignup );
    }


    if ($("#paypal-wrapper").length > 0) {

        // Check form before submission
        function paypalSubmit(){
            var paypal_business = $('input[name="business"]:checked').val();
            var paypal_payment_method = $('input[name="paypal_payment_method"]:checked').val();

            if (((paypal_payment_method == PayPal_WPS || paypal_payment_method == PayPal_ECS) &&
                (($('input[name="api_username"]').val().length <= 0) ||
                ($('input[name="api_password"]').val().length <= 0) ||
                ($('input[name="api_signature"]').val().length <= 0))) ||
                ((paypal_payment_method == PayPal_HSS &&
                ($('input[name="api_business_account"]').val().length <= 0))) ||
                (paypal_payment_method == PayPal_PPP &&
                (($('input[name="client_id"]').val().length <= 0) ||
                ($('input[name="secret"]').val().length <= 0)))) {
                $.fancybox({'content': $('<div id="js-paypal-save-failure">').append($('#js-paypal-save-failure').clone().html())});

                return false;
            }
            return true;
        }

        if(jquery_version[0]>=1 && jquery_version[1] >= 7) {
            $('input[type="submit"]').on('click', paypalSubmit);
        } else {
            $('input[type="submit"]').click( paypalSubmit );
        }

        // Display warning when turning on sandbox mode
        function sandboxMode() {
            if ($('input[name="sandbox_mode"]:checked').val() == '1') {
                $('input[name="sandbox_mode"]').filter('[value="0"]').attr('checked', true);
                var div = $('<div id="paypal-test-mode-confirmation">');
                var inner = $('#paypal-test-mode-confirmation').clone().html();
                $.fancybox({'hideOnOverlayClick': true, 'content': div.append(inner)});

                $('button.sandbox_confirm').on('click', function () {
                    jQuery.fancybox.close();
                    if ($(this).val() == '1') {
                        $('input[name="sandbox_mode"]').filter('[value="1"]').attr('checked', true);
                    } else {
                        $('input[name="sandbox_mode"]').filter('[value="0"]').attr('checked', true);
                    }
                });

                return false;
            }
            return true;
        }

        if(jquery_version[0]>=1 && jquery_version[1] >= 7) {
            $('input[name="sandbox_mode"]').on('change', sandboxMode);
        } else {
            $('input[name="sandbox_mode"]').change( sandboxMode );
        }

        if ($('#paypal-save-success').length > 0)
            $.fancybox({'hideOnOverlayClick': true, 'content': $('<div id="paypal-save-success">').append($('#paypal-save-success').clone().html())});
        else if ($('#paypal-save-failure').length > 0)
        {
            $.fancybox({'hideOnOverlayClick': true, 'content': $('<div id="paypal-save-failure">').append($('#paypal-save-failure').clone().html())});

        }

        // Displays how to get PayPal identification
        function getIdentification() {
            identificationButtonClicked = true;
            sandbox_prefix = $('#paypal_payment_test_mode').is(':checked') ? 'sandbox.' : '';
            var url = 'https://www.' + sandbox_prefix + 'paypal.com/us/cgi-bin/webscr?cmd=_get-api-signature&generic-flow=true';
            var title = 'PayPal identification informations';
            window.open(url, title, config = 'height=500, width=360, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
            return false;
        }

        if(jquery_version[0]>=1 && jquery_version[1] >= 7) {
            $('#paypal-get-identification').on('click', getIdentification);
        } else {
            $('#paypal-get-identification').click( getIdentification );
        }


        function loginActivate() {
            var val = parseInt($(this).val());
            if (val === 1)
            {
                $("#paypal_login_configuration").slideDown();
            }
            else
            {
                $("#paypal_login_configuration").slideUp();
            }
        }

        if(jquery_version[0]>=1 && jquery_version[1] >= 7) {
            $("#paypal_login_yes_or_no input[name='paypal_login']").on('change', loginActivate);
        } else {
            $("#paypal_login_yes_or_no input[name='paypal_login']").change(loginActivate);
        }
    }

    $('#test_ssl_submit').click(function() {
        $('#test_ssl_result').load(tlscurltest_url);
    });

});

var PaypalSectionManager = {

    hide: function(selector) {
        var elems = document.querySelectorAll(selector);

        elems.forEach(function(elem) {
            elem.style.display = 'none';
        });
    },

    show: function (selector) {
        var elems = document.querySelectorAll(selector);

        elems.forEach(function(elem) {
            elem.style.display = 'block';
        });
    },
    
    hideOpenAccountSection: function () {
        this.hide('[data-open-account-section]');
    },
    
    showOpenAccountSection: function () {
        this.show('[data-open-account-section]');
    },
    
    hideTlsCheckSection: function () {
        this.hide('[data-tls-check-section]');
    },
    
    showTlsCheckSection: function () {
        this.show('[data-tls-check-section]');
    },

    hideConfigurationSection: function () {
        this.hide('[data-configuration-section]');
    },

    showConfigurationSection: function () {
        this.show('[data-configuration-section]');
    }
};
