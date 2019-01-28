@php
    $subscription_reference = 'cash_' . str_random(6);
@endphp

<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_cash_checkout_form',$gateway) @endphp

        <div class="row">
            <div class="col-md-8">
                <p class="bg-info p-10 text-white">
                    {!!  trans('Cash::labels.cash.make_payment_directly',['arg' => $subscription_reference]) !!}
                </p>

                <div class="panel-body bg-primary cash-info p-10 text-white"> {!! $gateway->getCashNotes() !!}</div>


                <input type='hidden' name='checkoutToken' value='{{ $subscription_reference  }}'/>
                <input type='hidden' name='gateway' value='Cash'/>
            </div>

        </div>

    </div>

</div>