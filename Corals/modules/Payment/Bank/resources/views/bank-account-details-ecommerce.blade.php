@php
    $subscription_reference = 'bank_' . str_random(6);
@endphp

<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_bank_checkout_form',$gateway) @endphp
        <form action="{{ url($action) }}" method="post" id="payment-form" class="ajax-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="row">
                <div class="col-md-8">
                    <p class="bg-info p-10 text-white">
                        {!!  trans('Bank::labels.bank.make_payment_directly',['arg' => $subscription_reference]) !!}
                    </p>
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>@lang('Bank::labels.bank.account_information')</h4></div>
                        <div class="panel-body bg-primary bank-info p-10 text-white"> {!! $gateway->getBankInfo() !!}</div>
                    </div>


                    <input type='hidden' name='checkoutToken' value='{{ $subscription_reference  }}'/>
                    <input type='hidden' name='gateway' value='Bank'/>
                </div>

            </div>
        </form>
    </div>

</div>