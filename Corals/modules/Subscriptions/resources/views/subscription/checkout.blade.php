@extends('layouts.master')

@section('title',$title)

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1 offset-md-1">
            @component('components.box')
                @slot('box_title')
                    @lang('Subscriptions::labels.subscription.checkout_details')
                @endslot
                <form action="{{ url('subscriptions/do-checkout/'.$plan->hashed_id) }}" method="post" id="payment-form"
                      @if(!$require_payment_step) class="ajax-form"@endif>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <div id="checkoutWizard">
                        <ul>
                            <li><a href="#cart-details">@lang('Subscriptions::labels.subscription.subscription_details')
                                    <br/>
                                    <small></small>
                                </a></li>

                            <li>
                                <a href="#billing-shipping-address">@lang('Subscriptions::labels.subscription.address_details')
                                    <br/>
                                    <small></small>
                                </a></li>
                            @if($require_payment_step)
                                <li>
                                    <a href="#select-payment">@lang('Subscriptions::labels.subscription.payment_details')
                                        <br/>
                                        <small></small>
                                    </a></li>
                            @endif

                        </ul>

                        <div class="m-t-10" id="checkoutSteps">
                            <div id="cart-details" class="checkoutStep step-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table color-table info-table table table-hover table-striped table-condensed">
                                                <thead>
                                                <tr>
                                                    <th class="table-image"></th>
                                                    <th>@lang('Subscriptions::attributes.subscription.product_id')</th>
                                                    <th>@lang('Subscriptions::attributes.subscription.plan_id')</th>
                                                    <th>@lang('Corals::labels.action')</th>
                                                    <th>@lang('Subscriptions::attributes.subscription.pricing')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($plan)
                                                    <tr>
                                                        <td class="table-image vcenter">
                                                            <a href="{{ url('subscriptions/select', [$plan->product->hashed_id]) }}"
                                                               target="_blank">
                                                                <img src="{{ $plan->product->image }}"
                                                                     alt="product Image"
                                                                     class="img-rounded img-responsive" width="50"></a>
                                                        </td>
                                                        <td class="vcenter">
                                                            <a target="_blank"
                                                               href="{{ url('subscriptions/select', [$plan->product->hashed_id]) }}">
                                                                {{ $plan->product->name }}</a>

                                                        </td>
                                                        <td class="vcenter">
                                                            <b>{{ $plan->name }}</b>

                                                        </td>
                                                        <td class="vcenter"><b> <label
                                                                        class="label label-info">@lang('Subscriptions::labels.subscription.subscribe')</label>
                                                            </b>
                                                        </td>
                                                        <td class="vcenter"> {{  \Payments::currency($plan->price) }}
                                                            /
                                                            <span class="vpt_year">{!! $plan->cycle_caption  !!}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($current_plan)
                                                    <tr>
                                                        <td class="table-image vcenter">
                                                            <a href="{{ url('subscriptions/select', [$current_plan->product->hashed_id]) }}"
                                                               target="_blank">
                                                                <img src="{{ $current_plan->product->image }}"
                                                                     alt="product Image"
                                                                     class="img-rounded img-responsive" width="50"></a>
                                                        </td>
                                                        <td class="vcenter">
                                                            <a target="_blank"
                                                               href="{{ url('subscriptions/select', [$plan->product->hashed_id]) }}">
                                                                {{ $current_plan->product->name }}
                                                            </a>
                                                        </td>
                                                        <td class="vcenter">
                                                            <b>{{ $current_plan->name }}</b>

                                                        </td>
                                                        <td class="vcenter"><b> <label
                                                                        class="label label-danger">@lang('Corals::labels.confirmation.cancel')</label>
                                                            </b>
                                                        </td>
                                                        <td class="vcenter"> {{  \Payments::currency($current_plan->price ) }}
                                                            /
                                                            <span class="vpt_year">{!! $current_plan->cycle_caption  !!}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="billing-shipping-address" class="checkoutStep step-1" data-toggle="validator">
                                @include('Subscriptions::subscription.partials.address',['shipping_address'=>$shipping_address,'enable_shipping'=>$enable_shipping , 'billing_address' =>$billing_address])
                                @if(!$require_payment_step)
                                    @if($gateway)
                                        <input type='hidden' name='gateway' value='{{ $gateway->getName() }}'/>
                                    @endif
                                    <div class="text-right">
                                        {!! CoralsForm::button('Subscriptions::labels.subscription.check_out',['class'=>'btn btn-success'], 'submit') !!}
                                        {!! CoralsForm::link(url('dashboard'), 'Corals::labels.cancel',['class'=>'btn btn-warning']) !!}
                                    </div>
                                @endif
                            </div>
                            @if($require_payment_step)
                                <div id="select-payment" class="checkoutStep step-3" data-toggle="validator">
                                    @if($gateway)
                                        <h4>@lang('Subscriptions::labels.subscription.payment_details')</h4>
                                        <hr>
                                        @include($gateway->getPaymentViewName('subscription'))

                                    @else
                                        @php \Actions::do_action('pre_checkout_form',$plan,$gateway) @endphp
                                        <h4>@lang('Subscriptions::labels.subscription.payment_details')</h4>
                                        <hr>
                                        <div class="">
                                            {!! CoralsForm::radio('gateway','Subscriptions::attributes.subscription.select_payment_method',true,  \Payments::getAvailableGateways()  ) !!}
                                        </div>
                                        <div id="gatewayPayment">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <span data-name="checkoutToken"></span>
                                    </div>
                                    <div class="text-right">
                                        {!! CoralsForm::button('Subscriptions::labels.subscription.check_out',['class'=>'btn btn-success','id'=>'subscription-checkout'], 'submit') !!}
                                        {!! CoralsForm::link(url('dashboard'), 'Corals::labels.cancel',['class'=>'btn btn-warning']) !!}
                                    </div>


                                </div>
                            @endif
                        </div>
                    </div>

                </form>
        </div>
        @endcomponent
    </div>
@endsection

@section('js')

    <script type="application/javascript">

        $(document).ready(function () {
            $('.required-field input').prop('required', true);

            // Smart Wizard
            $('#checkoutWizard').smartWizard({
                selected: 0,
                ajaxSettings: {'data': '_token={{ csrf_token() }}', 'type': 'GET'},
                theme: 'arrows',
                useURLhash: false,
                keyNavigation: true,
                contentCache: false,
                transitionEffect: 'fade',
                toolbarSettings: {
                    toolbarPosition: 'bottom'
                },
                lang: {
                    next: '{{ trans('Corals::labels.next') }}',
                    previous: '{{ trans('Corals::labels.previous') }}'
                },
            });

            $("#checkoutWizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $(".checkoutStep.step-" + stepNumber);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward' && elmForm) {
                    elmForm.validator('validate');
                    var elmErr = elmForm.find('.has-error');
                    if (elmErr && elmErr.length > 0) {
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            });
            var plan_id = '{{ $plan->hashed_id }}';
            var gateway = '';
            $('input[name="gateway"]').on('change', function () {
                if ($(this).prop('checked')) {
                    if ($(this).prop('checked') && $(this).val() !== gateway) {
                        gateway = $(this).val();
                        var url = '{{ url('subscriptions/gateway-payment') }}' + "/" + gateway + "/" + plan_id;
                        $("#gatewayPayment").empty();
                        $("#gatewayPayment").load(url);
                    }
                }
            });


            $('#copy_billing').change(function (event) {
                if ($(this).prop('checked')) {
                    $('input[name="shipping_address[address_1]"]').val($('input[name="billing_address[address_1]"]').val());
                    $('input[name="shipping_address[address_2]"]').val($('input[name="billing_address[address_2]"]').val());
                    $('input[name="shipping_address[city]"]').val($('input[name="billing_address[city]"]').val());
                    $('input[name="shipping_address[state]"]').val($('input[name="billing_address[state]"]').val());
                    $('input[name="shipping_address[zip]"]').val($('input[name="billing_address[zip]"]').val());
                    $('select[name="shipping_address[country]"]').val($('select[name="billing_address[country]"]').val());
                    $('select[name="shipping_address[country]"]').trigger('change');
                }
            });

        });

    </script>
@endsection