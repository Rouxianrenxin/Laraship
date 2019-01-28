<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @lang('SecurionPay::labels.card.title')
            @endslot
            @if(user()->card_brand)
                <p><span class="text-muted">@lang('SecurionPay::labels.card.current_card_brand')</span>
                    <b>{{ user()->card_brand }}</b></p>
                <p><span class="text-muted">@lang('SecurionPay::labels.card.current_card_last')</span>
                    <b>{{ user()->card_last_four }}</b></p>
                <hr/>
            @endif
            <br/>
            @php \Actions::do_action('pre_securionpay_checkout_form',$gateway) @endphp

                <label for="card-element">
                    @lang('SecurionPay::labels.card.credit_or_debit')
                </label>
                <div class="row">
                    <!-- custom fields can be added here -->
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','SecurionPay::attributes.card.name',true,null,['data-securionpay'=>"number"]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 p-r-0">
                        {!! CoralsForm::number('expMonth','SecurionPay::attributes.card.expMonth',true,null,['data-securionpay'=>"expMonth", 'placeholder'=>"MM"]) !!}
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
            <br/>

        @endcomponent
    </div>
</div>


<script type="text/javascript">
    var isAjax = '{{ request()->ajax() }}';

    window.onload = function () {
        initSecurionPay();
    };

    if (isAjax == '1') {
        initSecurionPay();
    }

    function initSecurionPay() {
        $.getScript("https://securionpay.com/js/securionpay.js", function () {
            Securionpay.setPublicKey('{{ $gateway->getApiPublicKey() }}');

            var $form = $('#payment-form');

            $form.submit(function (event) {
                event.preventDefault();

                // Disable form submit button to prevent repeatable submits
                $form.find('button').prop('disabled', true);

                // Send card data to SecurionPay
                SecurionPay.createCardToken($form, createCardTokenCallback);
            });

            function createCardTokenCallback(token) {
                // Check for errors
                if (token.error) {
                    // Display error message
                    $('#payment-error').text(token.error.message).removeClass('hidden');
                    // Re-enable form submit button
                    $form.find('button').prop('disabled', false);
                } else {
                    // Append token to the form so that it will be send to server
                    $form.append($('<input type="hidden" name="checkoutToken" />').val(token.id));
                    $form.append("<input type='hidden' name='card_last_four' value='" + token.last4 + "'/>");
                    $form.append("<input type='hidden' name='card_brand' value='" + token.brand + "'/>");
                    $form.append("<input type='hidden' name='gateway' value='SecurionPay'/>");
                    $form.addClass('ajax-form');
                    $form.get(0).submit();
                }
            }
        });
    }
</script>