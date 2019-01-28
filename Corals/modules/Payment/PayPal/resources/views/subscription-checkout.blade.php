<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_paypal_checkout_form',$gateway) @endphp
        <div id="paypal-button"></div>
    </div>
</div>


<script>
    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initPayPal();
    };

    if (isAjax === '1') {
        initPayPal();
    }

    function initPayPal() {
        $('#payment-form').addClass('ajax-form');

        if (window.paypal) {
            payPalCallback();
        } else {
            $.getScript("https://www.paypalobjects.com/api/checkout.js").done(function (script, textStatus) {
                payPalCallback()
            });
        }

    }

    function payPalCallback() {
        //event.preventDefault();
        paypal.Button.render({
            env: '@if($gateway->getTestMode()){{'sandbox'}}@else{{'production'}}@endif', // Or 'production',
            commit: true, // Show a 'Pay Now' button
            client: {
                '@if($gateway->getTestMode()){{'sandbox'}}@else{{'production'}}@endif': '{{ $gateway->getClientId() }}', // switch to 'production' if in prod
            },

            payment: function (resolve, reject) {
                var plan_id = '{{$gateway->getPlanIntegrationId($plan)}}'; // change this to be the actual paypal plan ID

                $.ajax({
                    url: '{{url('subscriptions/gateway-subscription-token/'.$gateway->getName().'/'.$plan->hashed_id) }}',
                    type: 'GET',
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (data, status, xhr) {
                        console.log(data);

                        token = data.approval_url.params.token;
                        resolve(token);
                    },
                    error: function (xhr, status, error) {
                        console.log('checkout error', error);
                        alert('Error')
                    },
                });
            },

            onAuthorize: function (data, actions) {
                $form = $('#payment-form');
                $form.append("<input type='hidden' name='checkoutToken' value='" + data.paymentToken + "'/>");
                $form.append("<input type='hidden' name='gateway' value='PayPal_Rest'/>");
                $("#subscription-checkout").trigger('click');

            },
        }, '#paypal-button');
    }
</script>