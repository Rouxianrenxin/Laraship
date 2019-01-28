@php $products = \Shop::getFeaturedProducts(); @endphp
@if(!$products->isEmpty())
    <h3 class="title mt-4">@lang('corals-ecommerce-mimity::labels.partial.featured_products')</h3>
    <div class="content-slider">
        <div class="swiper-container" id="popular-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="row no-gutters gutters-2">
                        @foreach($products as $product)
                            @include('partials.product_grid_item',compact('product'))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
