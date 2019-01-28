@extends('layouts.master')

@section('title',$title)

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 offset-md-3">
            @component('components.box')
                <h4>@lang('Subscriptions::labels.subscription.select_payment_method')</h4>
                <div class="">
                    {!! CoralsForm::radio('gateway','Subscriptions::attributes.subscription.gateway',true, \Payments::getAvailableGateways() ) !!}
                </div>
                <div id="gatewayPayment">

                </div>
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
    <script type="application/javascript">
        $(document).ready(function () {
            var plan_id = '{{ $plan->hashed_id }}';
            $('input[name="gateway"]').on('change', function () {
                if ($(this).prop('checked')) {
                    var gatewayName = $(this).val();
                    var url = '{{ url('subscriptions/gateway-payment') }}' + "/" + gatewayName + "/" + plan_id;
                    $("#gatewayPayment").empty();
                    $("#gatewayPayment").load(url);
                }
            });
        });
    </script>
@endsection
