<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('PayPal::labels.paypal.title')
            @endslot
            <p></p>
            @php \Actions::do_action('pre_paypal_checkout_form',$gateway) @endphp

            <form action="{{ url($action) }}"
                  method="post" id="payment-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>


                <br/>
            </form>
            <div id="paypal-button"></div>
        @endcomponent
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
        if (window.paypal) {
            payPalCallback();
        } else {
            $.getScript("https://www.paypalobjects.com/api/checkout.js").done(function (script, textStatus) {
                payPalCallback()
            });
        }
    }

    function payPalCallback(event) {
        //event.preventDefault();
        paypal.Button.render({
            env: '@if($gateway->getTestMode()){{'sandbox'}}@else{{'production'}}@endif', // Or 'production',
            commit: true, // Show a 'Pay Now' button
            client: {
                '@if($gateway->getTestMode()){{'sandbox'}}@else{{'production'}}@endif': '{{ $gateway->getClientId() }}', // switch to 'production' if in prod
            },

            payment: function (resolve, reject) {

                $.ajax({
                    url: '{{url('marketplace/gateway-payment-token/'.$gateway->getName().'/'.$amount) }}',
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
                console.log(data);
                $form.append("<input type='hidden' name='checkoutToken[payerID]' value='" + data.payerID + "'/>");
                $form.append("<input type='hidden' name='checkoutToken[paymentID]' value='" + data.paymentID + "'/>");
                $form.append("<input type='hidden' name='gateway' value='PayPal_Rest'/>");
                ajax_form($form);

            },
        }, '#paypal-button');
        // Handle form submission

        // Handle form submission
        $('#payment-form').on('submit', function (event) {
            if (!$('input[name=gateway]').val()) {
                return false;
            }
            event.preventDefault();
            ajax_form($(this));
        });
    }
</script>