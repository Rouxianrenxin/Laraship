<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('Omise::labels.checkout.title')
            @endslot
            <p></p>
            @php \Actions::do_action('pre_omise_checkout_form',$gateway) @endphp

            <form id="payment-form" action="{{ url($action) }}"
                  method="post" id="payment-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="form-row">

                    <div class="row">
                        <!-- custom fields can be added here -->
                        <div class="col-md-6">
                            {!! CoralsForm::text('holder_name','Omise::attributes.omise.holder_name',true,'') !!}
                        </div>
                        <div class="col-md-6">
                            {!! CoralsForm::text('card_number','Omise::attributes.omise.card_number',true,'') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 p-r-0">
                            {!! CoralsForm::number('expMonth','Omise::attributes.omise.expMonth',true,'',[ 'placeholder'=>"MM"]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! CoralsForm::number('expYear','&nbsp;',true,'',['placeholder'=>"YY"]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! CoralsForm::number('ccv','CCV',true,'',['placeholder'=>"CCV"]) !!}
                        </div>
                    </div>
                    <!-- Used to display form errors -->
                    <div id="payment-error" class="alert alert-danger hidden"></div>

                </div>
            </form>
        @endcomponent
    </div>
</div>

<script>
    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initOmise();
    };

    if (isAjax == '1') {
        initOmise();
    }


    function initOmise() {
        $.getScript("https://cdn.omise.co/omise.js", function () {

            // Set Omise Public Key (from omise.co > log in > Keys tab)

            Omise.setPublicKey("{{ $gateway->getPublicKey()  }}");

            var tokenRequest = function () {
                $("#payment-error").addClass('hidden');
                // Setup token request arguments
                // Make the token request
                // Serialize the form fields into a valid card object.
                var card = {
                    "name": $("#holder_name").val(),
                    "number": $("#card_number").val(),
                    "expiration_month": $("#expMonth").val(),
                    "expiration_year": $("#expYear").val(),
                    "security_code": $("#ccv").val()
                };
                // Send a request to create a token then trigger the callback function once
                // a response is received from Omise.
                //
                // Note that the response could be an error and this needs to be handled within
                // the callback.
                Omise.createToken("card", card, function (statusCode, response) {
                    if (response.object == "error") {
                        // Display an error message.
                        // Re-enable the submit button.
                        $("#payment-error").html('Request Payment Method Error: ' + response.message).removeClass('hidden');
                        if (window.Ladda) {
                            Ladda.stopAll();
                        }
                        return false;
                    } else {

                        $form = $('#payment-form');
                        // insert the token into the form so it gets submitted to the server
                        $form.append("<input type='hidden' name='checkoutToken' value='" + response.id + "'/>");
                        $form.append("<input type='hidden' name='gateway' value='Omise'/>");
                        $form.addClass('ajax-form');
                        // And submit the form.
                        ajax_form($form);

                    }
                    ;
                });
            };

            $(function () {
                $('#payment-form').submit(function (e) {
                    // Call our token request function
                    e.preventDefault();
                    tokenRequest();

                    // Prevent form from submitting
                    return false;
                });
            });

        });
    }
</script>