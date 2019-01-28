<div class="product-card mb-30">
    @if($product->discount)
        <div class="product-badge bg-danger">{{ $product->discount }} %off</div>
    @endif
    <span class="product-rating">
        @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
            @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>null])
        @endif
     </span>
    <a class="product-thumb mt-4" href="{{ url('shop/'.$product->slug) }}">
        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="mx-auto"
             style="max-height: 150px;width: auto;">
    </a>
    <div class="product-card-body">
        <h3 class="product-title"><a href="{{ url('shop/'.$product->slug) }}">{{ $product->name }}</a></h3>
        <h4 class="product-price">
            @if($product->discount)
                <del>{{ \Payments::currency($product->regular_price) }}</del>
            @endif
            {!! $product->price !!}
        </h4>
    </div>
    <div class="product-button-group">
        @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
            @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
        @endif
        @if(!$product->isSimple || $product->attributes()->count())
            @if($product->external_url)
                <a href="{{ $product->external_url }}" target="_blank" class="product-button"
                   title="Buy Product">
                    @lang('corals-ecommerce-ultimate::labels.partial.buy_product')
                </a>
            @else
                <a href="{{ url('shop/'.$product->slug) }}" class="product-button">
                    <i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i>
                    <span>@lang('corals-ecommerce-ultimate::labels.partial.add_to_cart')</span>
                </a>
            @endif
        @else
            @php $sku = $product->activeSKU(true); @endphp
            @if($sku->stock_status == "in_stock")
                @if($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" class="product-button"
                       title="Buy Product">
                        @lang('corals-ecommerce-ultimate::labels.partial.buy_product')
                    </a>
                @else
                    <a href="{{ url('cart/'.$product->hashed_id.'/add-to-cart/'.$sku->hashed_id) }}"
                       class="product-button btn-cart ladaa"
                       data-action="post" data-page_action="updateCart">
                        <i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i>
                        <span>@lang('corals-ecommerce-ultimate::labels.partial.add_to_cart')</span>
                    </a>
                @endif
            @else
                <a href="#" class="product-button text-danger"
                   title="Out Of Stock">
                    @lang('corals-ecommerce-ultimate::labels.partial.out_stock')
                </a>
            @endif
        @endif
    </div>

</div>
