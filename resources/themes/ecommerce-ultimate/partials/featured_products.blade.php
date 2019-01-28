@php $products = \Shop::getFeaturedProducts(); @endphp

@if(!$products->isEmpty())
    <!-- Featured Products Carousel-->
    <section class="container padding-top-3x padding-bottom-3x">
        <h3 class="text-center mb-30">{{ $title?? trans('corals-ecommerce-ultimate::labels.partial.featured_products') }}</h3>
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('partials.product_grid_item',compact('product'))
                </div>
            @endforeach
        </div>
    </section>
@endif