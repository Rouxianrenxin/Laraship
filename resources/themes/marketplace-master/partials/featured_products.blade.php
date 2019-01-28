@php $products = \Shop::getFeaturedProducts(); @endphp

@if(!$products->isEmpty())
    <!-- Featured Products Carousel-->
    <section class="container padding-top-3x padding-bottom-3x">
        <h3 class="text-center mb-30">{{ $title?? trans('corals-marketplace-master::labels.partial.featured_products') }}</h3>
        <div class="owl-carousel"
             data-owl-carousel="{ &quot;rtl&quot;: @if(\Language::isRTL()){{'true'}}@else {{'false'}}@endif,&quot;nav&quot;: false, &quot;dots&quot;: true, &quot;margin&quot;: 30, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;576&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
            @foreach($products as $product)
                @include('partials.product_grid_item',compact('product'))
            @endforeach
        </div>
    </section>
@endif