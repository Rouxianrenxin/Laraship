<section class="container mt-80 mb-100">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="heading text-center">{{ $title??'Featured Products' }}</h3>
        </div>
        @php $products = \Shop::getFeaturedProducts(); @endphp

        @if(!$products->isEmpty())
            <div class="owl-carousel"
                 data-owl-carousel="{ &quot;nav&quot;: false,&quot;rewindNav&quot;: false,&quot;rtl&quot;: @if(\Language::isRTL()){{'true'}}@else {{'false'}}@endif,&quot;loop&quot;: true,&quot;autoplay&quot;: true,&quot;autoplay&quot;: true,&quot;autoplayTimeout&quot;: 4000, &quot;dots&quot;: true, &quot;margin&quot;: 30, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;576&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
                @foreach($products as $product)
                    @include('partials.product_grid_item',compact('product'))
                @endforeach
            </div>
        @endif
    </div>
</section>