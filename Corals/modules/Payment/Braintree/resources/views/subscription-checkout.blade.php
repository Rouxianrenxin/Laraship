<?php
$tokenRequest = $gateway->clientToken();
$tokenResponse = $tokenRequest->send();
?>
<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('Braintree::labels.checkout.title')
            @endslot
            <p></p>
            @php \Actions::do_action('pre_braintree_checkout_form',$gateway) @endphp


            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>
            <br/>
        @endcomponent
    </div>
</div>


<script>
    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initBraintree();
    };

    if (isAjax == '1') {
        initBraintree();
    }

    function initBraintree() {
        $.getScript("https://js.braintreegateway.com/web/dropin/1.9.2/js/dropin.min.js", function () {
            var $form = $('#payment-form');
            var client_token = "{{ $tokenResponse->getToken() }}";

            braintree.dropin.create({
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
                        $form.append("<input type='hidden' name='gateway' value='Braintree'/>");
                        $form.addClass('ajax-form');

                        $form.get(0).submit();
                    });
                });
            });
        });
    }
</script>