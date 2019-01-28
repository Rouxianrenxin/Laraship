<div class="row">
    <div class="col-md-12">
        <h5>@lang('Stripe::labels.card.title')</h5>
        <hr>
        @if(user()->card_brand)
            <p><span class="text-muted">@lang('Stripe::labels.card.current_card_brand')</span>
                <b>{{ user()->card_brand }}</b></p>
            <p><span class="text-muted">@lang('Stripe::labels.card.current_card_last')</span>
                <b>{{ user()->card_last_four }}</b></p>
        @endif
        <br/>
        @php \Actions::do_action('pre_stripe_checkout_form', $gateway) @endphp

        <div class="card panel panel-default">
            <div class="card-header panel-heading">
                @lang('Stripe::labels.card.credit_or_debit')
            </div>
            <div class="card-body panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="card-element">
                            <!-- a Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <br/>
</div>



<script type="text/javascript">
    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initStripe();
    };

    if (isAjax === '1') {
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
                    lineHeight: '18px',
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
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        Ladda.stopAll();
                    } else {
                        // Send the token to server
                        $('#payment-form-btn').remove();
                        $('#cancel-btn').remove();

                        $form = $('#payment-form');
                        var token = result.token;
                        $form.append("<input type='hidden' name='checkoutToken' value='" + token.id + "'/>");
                        $form.append("<input type='hidden' name='card_last_four' value='" + token.card.last4 + "'/>");
                        $form.append("<input type='hidden' name='card_brand' value='" + token.card.brand + "'/>");
                        $form.append("<input type='hidden' name='gateway' value='Stripe'/>");
                        $form.addClass('ajax-form');
                        $form.get(0).submit();
                    }
                });
            });
        });
    }
</script>