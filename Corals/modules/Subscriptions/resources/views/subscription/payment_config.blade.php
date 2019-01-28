@extends('layouts.master')

@section('title',$title)

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 offset-md-1">
            <form action="{{ url('subscriptions/save-payment-configuration') }}" method="post" id="payment-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                <h4><i class="fa fa-check-circle"></i>@lang('Subscriptions::labels.subscription.update_payment_details')
                    :</h4>
                @include($gateway->getPaymentViewName('subscription'))
                {!! CoralsForm::formButtons('Subscriptions::labels.subscription.save',[], ['show_cancel'=>false]) !!}
            </form>
        </div>
    </div>
    </div>
@endsection