<div class="row">
    <div class="col-md-10 col-md-offset-1 offset-md-1">

        @if($gateway)
            <h4>@lang('Ecommerce::labels.checkout.enter_payment')</h4>
            <hr>
            @include($gateway->getPaymentViewName('ecommerce'),['action'=>$urlPrefix.'checkout/step/select-payment'])
        @else
            @php \Actions::do_action('pre_order_checkout_form',$gateway) @endphp
            <div class="">
                {!! Form::open( ['url' => url($urlPrefix.'checkout/step/select-payment'),'method'=>'POST','files'=>true,'class'=>'ajax-form','id'=>'PaymentForm']) !!}
                <h4>@lang('Ecommerce::labels.checkout.select_payment')</h4>
                <hr>
                <br>
                {!! CoralsForm::radio('select_gateway','',true,  $available_gateways ) !!}
                <div class="form-group">
                    <span data-name="checkoutToken"></span>
                </div>
            </div>
            {!! Form::close() !!}
            <div id="gatewayPayment">

            </div>
        @endif
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        var order_id = '{{ $order->hashed_id }}';
        $('input[name="select_gateway"]').on('change', function () {

            if ($(this).prop('checked')) {
                var gatewayName = $(this).val();
                var url = '{{ url('e-commerce/gateway-payment') }}' + "/" + gatewayName + "/" + order_id;
                $("#gatewayPayment").empty();
                $("#gatewayPayment").load(url);
            }
        });
    });
</script>
