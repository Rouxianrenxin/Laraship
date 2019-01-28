<?php
$tokenRequest = $gateway->clientToken();
$tokenResponse = $tokenRequest->send();
?>
<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('TwoCheckout::labels.checkout.title')
            @endslot
            <p></p>
            @php \Actions::do_action('pre_twocheckout_checkout_form',$gateway) @endphp

            <form id="payment-form" action="{{ url($action) }}"
                  method="post" id="payment-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
                </div>
            </form>
        @endcomponent
    </div>
</div>

<script>

    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initTwoCheckout();
    };

    if (isAjax == '1') {
        initTwoCheckout();
    }

    function initTwoCheckout() {
        $.getScript("https://js.twocheckoutgateway.com/web/dropin/1.9.2/js/dropin.min.js", function () {
            var $form = $('#payment-form');
            var client_token = "{{ $tokenResponse->getToken() }}";

            twocheckout.dropin.create({
                authorization: client_token,
                selector: '#bt-dropin',
                paypal: {
                    flow: 'vault'
                }
            }, function (createErr, instance) {
                if (createErr) {
                    console.log('Create Error', createErr);
                    return;
                }
                $form.submit(function (event) {
                    event.preventDefault();

                    instance.requestPaymentMethod(function (err, payload) {
                        if (err) {
                            console.log('Request Payment Method Error', err);
                            return;
                        }
                        $form = $('#payment-form');
                        // insert the token into the form so it gets submitted to the server
                        $form.append("<input type='hidden' name='checkoutToken' value='" + payload.nonce + "'/>");
                        $form.append("<input type='hidden' name='gateway' value='TwoCheckout'/>");
                        ajax_form($form);

                    });
                });
            });
            // Handle form submission
            $('#payment-form').on('submit', function (event) {
                if (!$('input[name=gateway]').val()) {
                    return false;
                }
                event.preventDefault();
                ajax_form($(this));
            });
        });
    }
</script>