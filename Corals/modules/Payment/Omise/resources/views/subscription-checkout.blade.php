<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('Omise::labels.checkout.title')
            @endslot
            <p></p>
            @php \Actions::do_action('pre_omise_checkout_form',$gateway) @endphp
            <label for="card-element">
                Credit or debit card
            </label>
            <div class="row">
                <!-- custom fields can be added here -->
                <div class="col-md-6">
                    {!! CoralsForm::text('card_number','Omise::attributes.omise.card_number',true,null) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 p-r-0">
                    {!! CoralsForm::number('expMonth','Omise::attributes.omise.expMonth',true,null,['data-securionpay'=>"expMonth", 'placeholder'=>"MM"]) !!}
                </div>
                <div class="col-md-2">
                    {!! CoralsForm::number('expYear','&nbsp;',true,null,['data-securionpay'=>"expYear", 'placeholder'=>"YY"]) !!}
                </div>
                <div class="col-md-2">
                    {!! CoralsForm::number('ccv','CCV',true,null,['data-securionpay'=>"ccv", 'placeholder'=>"CCV"]) !!}
                </div>
            </div>
            <!-- Used to display form errors -->
            <div id="payment-error" class="alert alert-danger hidden"></div>

        @endcomponent
    </div>

    <script>
        // Set Omise Public Key (from omise.co > log in > Keys tab)
        Omise.setPublicKey("pkey_test");
    </script>
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

                // Called when token created successfully.
                var successCallback = function (data) {
                    $form = $('#payment-form');
                    // insert the token into the form so it gets submitted to the server
                    $form.append("<input type='hidden' name='checkoutToken' value='" + data.response.token.token + "'/>");
                    $form.append("<input type='hidden' name='gateway' value='Omise'/>");
                    $form.addClass('ajax-form');

                    $form.get(0).submit();
                };

                // Called when token creation fails.
                var errorCallback = function (data) {
                    // Retry the token request if ajax call fails
                    if (data.errorCode === 200) {
                        // This error code indicates that the ajax call failed. We recommend that you retry the token request.
                    } else {

                        $("#payment-error").html('Request Payment Method Error: ' + data.errorMsg).removeClass('hidden');
                        if (window.Ladda) {
                            Ladda.stopAll();
                        }
                        return false;

                    }
                };

                var tokenRequest = function () {
                    $("#payment-error").addClass('hidden');
                    // Setup token request arguments
                    var args = {
                        sellerId: "{{ $gateway->getAccountNumber()  }}",
                        publishableKey: "{{ $gateway->getPublicKey()  }}",
                        ccNo: $("#card_number").val(),
                        cvv: $("#ccv").val(),
                        expMonth: $("#expMonth").val(),
                        expYear: $("#expYear").val()
                    };
                    // Make the token request
                    TCO.requestToken(successCallback, errorCallback, args);
                };

                $(function () {
                    // Pull in the public encryption key for our environment
                    TCO.loadPubKey("@if($gateway->getTestMode()){{'sandbox'}}@else{{'production'}}@endif");

                    $('#payment-form').submit(function (e) {
                        // Call our token request function
                        tokenRequest();

                        // Prevent form from submitting
                        return false;
                    });
                });

            });
        }
    </script>