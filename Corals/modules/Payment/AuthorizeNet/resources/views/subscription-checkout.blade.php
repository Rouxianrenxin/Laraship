<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('AuthorizeNet::labels.checkout.title')
            @endslot
            <p></p>
            @php \Actions::do_action('pre_authorizenet_checkout_form',$gateway) @endphp

                <div class="row">
                    <!-- custom fields can be added here -->
                    <div class="col-md-6">
                        {!! CoralsForm::text('card_number','AuthorizeNet::attributes.card_number',true,'') !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::number('zip_code','AuthorizeNet::attributes.zip_code',true,'',[ 'placeholder'=>trans('AuthorizeNet::attributes.zip_code')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 p-r-0">
                        {!! CoralsForm::number('expMonth','AuthorizeNet::attributes.expMonth',true,'',[ 'placeholder'=> "MM"]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! CoralsForm::number('expYear','&nbsp;',true,'',['placeholder'=>"YY"]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! CoralsForm::number('ccv','CCV',true,'',['placeholder'=>"CCV"]) !!}
                    </div>

                </div>
                <div id="payment-error" class="alert alert-danger hidden"></div>

                @endcomponent
    </div>

    <script type="text/javascript"
            src="https://@if($gateway->getDeveloperMode()){{'jstest'}}@else{{'js'}}@endif.authorize.net/v1/Accept.js"
            charset="utf-8"></script>

    <script>
        var isAjax = '{{ request()->ajax() }}';

        window.onload = function () {
            initAuthorizeNet();
        };

        if (isAjax == '1') {
            initAuthorizeNet();
        }

        function initAuthorizeNet() {
            $.getScript("https://@if($gateway->getDeveloperMode()){{'jstest'}}@else{{'js'}}@endif.authorize.net/v1/Accept.js", function () {

                var $form = $('#payment-form');

                $form.submit(function (event) {
                    event.preventDefault();

                    // Send card data to SecurionPay
                    getSecureData();
                });

                /* Form Submit Handler. Compiles data to be sent to Accept.js */
                function getSecureData() {
                    $("#payment-error").empty();
                    /* Compile Data from Form */

                    var secureData = {},
                        authData = {},
                        cardData = {};

                    cardData.cardNumber = $("#card_number").val();
                    cardData.month = $("#expMonth").val();
                    cardData.year = $("#expYear").val();
                    cardData.zip = $("#zip_code").val();
                    cardData.cardCode = $("#ccv").val();

                    /* Enter your Client Key and API Login from Authorize.net */
                    authData.clientKey = '{{$gateway->getClientKey()}}';
                    authData.apiLoginID = '{{$gateway->getApiLoginId()}}';

                    secureData.cardData = cardData;
                    secureData.authData = authData;


                    /* Dispatch Data */

                    Accept.dispatchData(secureData, 'responseHandler');

                }


                /* Accept Response Handler */
                responseHandler = function (response) {
                    console.log(response);

                    if (response.messages.resultCode === 'Error') {
                        $("#payment-error").html('Request Payment Method Error: <br> ').removeClass('hidden');

                        for (var i = 0; i < response.messages.message.length; i++) {
                            $("#payment-error").append(response.messages.message[i].text + "<br>")
                        }
                        if (window.Ladda) {
                            Ladda.stopAll();
                        }
                        return false;

                    } else {
                        useOpaqueData(response.opaqueData);

                    }

                }

                /* Handle the Payment Nonce returned by Accept.js */
                function useOpaqueData(responseData) {


                    //console.debug("\n#3: useOpaqueData()");
                    //console.log(responseData.dataDescriptor);
                    //console.log(responseData.dataValue);

                    /* Display Payment Nonce. DONT DO THIS IN PRODUCTION OBVIOUSLY */
                    // $("#blob").val(responseData.dataValue);

                    /* Pass the Nonce to createTransact to create a transaction */
                    $form = $('#payment-form');
                    // insert the token into the form so it gets submitted to the server
                    $form.append("<input type='hidden' name='checkoutToken' value='" + responseData.dataValue + "|" + responseData.dataDescriptor + "'/>");
                    $form.append("<input type='hidden' name='gateway' value='AuthorizeNet'/>");
                    $form.addClass('ajax-form');
                    $form.get(0).submit();
                }


            });

        }
    </script>