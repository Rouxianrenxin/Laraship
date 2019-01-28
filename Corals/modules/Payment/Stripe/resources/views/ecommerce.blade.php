<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_stripe_checkout_form',$gateway) @endphp
        <form action="{{ url($action) }}" method="post" id="payment-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="card panel panel-default">
                <div class="card-header panel-heading">
                    @lang('Stripe::labels.card.credit_or_debit')
                </div>
                <div class="card-body panel-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div id="card-element" style="width: 100%;">
                                <!-- a Stripe Element will be inserted here. -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initStripe();
    };

    if (isAjax == '1') {
        initStripe();
    }

    function initStripe() {
        $.getScript("https://js.stripe.com/v3/", function () {
            // Create a Stripe client
            var stripe = Stripe('{{ $gateway->getApiPublicKey() }}');

            // Create an instance of Elements
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element
            var card = elements.create('card', {style: style});

            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            $('#payment-form').on('submit', function (event) {
                event.preventDefault();

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to server
                        $('#payment-form-btn').remove();
                        $('#cancel-btn').remove();

                        $form = $('#payment-form');
                        var token = result.token;
                        // insert the token into the form so it gets submitted to the server
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='checkoutToken' value='" + token.id + "'/>");
                        $form.append("<input type='hidden' name='card_last_four' value='" + token.card.last4 + "'/>");
                        $form.append("<input type='hidden' name='card_brand' value='" + token.card.brand + "'/>");
                        $form.append("<input type='hidden' name='gateway' value='Stripe'/>");
                        ajax_form($form);
                    }
                });
            });
        });
    }
</script>