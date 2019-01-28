<!-- latest products Section start -->
<section class="featured section-padding">
    <div class="container">
        <h1 class="section-title">@lang('corals-classified-master::labels.partial.latest_products')</h1>
        <div class="d-flex flex-wrap justify-content-between">
            @foreach(\Classified::getProductsList(true, 6) as $product)
                @include('partials.product_grid_item', ['item_class'=>'three-columns', 'product'=> $product])
            @endforeach
        </div>
    </div>
</section>
<!-- latest products Section End -->
