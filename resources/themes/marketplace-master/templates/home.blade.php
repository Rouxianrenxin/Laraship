@extends('layouts.public')

@section('editable_content')
    @php \Actions::do_action('pre_content',$item, $home??null) @endphp

    {!! $item->rendered !!}

    @include('partials.featured_categories')
    @include('partials.featured_products')
    @include('partials.three_column_lists')
    @include('partials.featured_brands')

    <section class="container padding-top-2x padding-bottom-2x">
        <div class="row">
            <div class="col-md-3 col-sm-6 text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/marketplace-master/img/services/01.png"
                        alt="Shipping">
                <h6>@lang('corals-marketplace-master::labels.template.home.free_worldwide')</h6>
                <p class="text-muted margin-bottom-none">@lang('corals-marketplace-master::labels.template.home.free_shipping')</p>
            </div>
            <div class="col-md-3 col-sm-6 text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/marketplace-master/img/services/02.png"
                        alt="Money Back">
                <h6>@lang('corals-marketplace-master::labels.template.home.money_back_guarantee')</h6>
                <p class="text-muted margin-bottom-none">@lang('corals-marketplace-master::labels.template.home.money_days')</p>
            </div>
            <div class="col-md-3 col-sm-6 text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/marketplace-master/img/services/03.png"
                        alt="Support">
                <h6>@lang('corals-marketplace-master::labels.template.home.customer_support')</h6>
                <p class="text-muted margin-bottom-none">@lang('corals-marketplace-master::labels.template.home.friendly_customer_support')</p>
            </div>
            <div class="col-md-3 col-sm-6 text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/marketplace-master/img/services/04.png"
                        alt="Payment">
                <h6>@lang('corals-marketplace-master::labels.template.home.secure_online_payment')</h6>
                <p class="text-muted margin-bottom-none">@lang('corals-marketplace-master::labels.template.home.posess_ssl')</p>
            </div>
        </div>
        <div class="text-center">
            @php \Actions::do_action('pre_display_footer') @endphp
        </div>
    </section>


@stop


@section('js')
    @parent
    @include('Marketplace::cart.cart_script')
@endsection
