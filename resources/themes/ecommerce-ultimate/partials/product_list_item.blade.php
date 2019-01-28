<div class="product-card product-list mb-30">
    <a class="product-thumb" href="{{ url('shop/'.$product->slug) }}">
        @if($product->discount)
            <div class="product-badge text-danger">{{ $product->discount }}% Off</div>
        @endif
        <img class="mx-auto product-url-image" src="{{ $product->image }}" alt="{{ $product->name }}">
    </a>
    <div class="product-card-inner">
        @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
            @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>null])
        @endif
        <div class="product-card-body">
            <h3 class="product-title"><a href="{{ url('shop/'.$product->slug) }}">
                    {{ $product->name }}</a></h3>
            <h4 class="product-price">
                @if($product->discount)
                    <del>{{ \Payments::currency($product->regular_price) }}</del>
                @endif
                {!! $product->price !!}
            </h4>
            <p class="text-sm text-muted hidden-xs-down my-1">
                {!! str_limit(strip_tags($product->description),500) !!}
            </p>
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
</div>