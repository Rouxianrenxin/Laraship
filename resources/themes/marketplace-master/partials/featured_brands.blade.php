@php $brands = \Shop::getFeaturedBrands(); @endphp
@if(!$brands->isEmpty())
    <section class="bg-faded padding-top-3x padding-bottom-3x">
        <div class="container">
            <h3 class="text-center mb-30 pb-2">@lang('corals-marketplace-master::labels.partial.popular_brands')</h3>
            <div class="owl-carousel"
                 data-owl-carousel="{ &quot;rtl&quot;: @if(\Language::isRTL()){{'true'}}@else {{'false'}}@endif,&quot;nav&quot;: false, &quot;dots&quot;: false, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2}, &quot;470&quot;:{&quot;items&quot;:3}} }">
                @foreach($brands as $brand)
                    <a href="{{ url('shop?brand[]='.$brand->slug) }}" title="{{ $brand->name }}">
                        <img class="d-block opacity-75 m-auto" src="{{ $brand->thumbnail }}"
                             style="max-height: 110px; width: auto;"
                             alt="{{ $brand->name }}">
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif