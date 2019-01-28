@extends('layouts.master')

@section('editable_content')
    @php \Actions::do_action('pre_content', null, null) @endphp
    <div class="container padding-bottom-3x mb-2">
        <div class="card text-center">
            <div class="card-body padding-top-2x">
                <h3 class="card-title">@lang('corals-ecommerce-ultimate::labels.template.checkout_success.success')</h3>
                <p class="card-text">@lang('corals-ecommerce-ultimate::labels.template.checkout_success.order_has_been_placed')</p>
                <div class="padding-top-1x padding-bottom-1x">

                    <a class="btn btn-outline-primary"
                       href="{{ url('e-commerce/orders/my') }}">@lang('corals-ecommerce-ultimate::labels.template.checkout_success.go_my_order')</a>
                </div>
            </div>
        </div>
    </div>
@stop