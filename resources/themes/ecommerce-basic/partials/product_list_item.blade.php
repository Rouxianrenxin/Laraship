<!-- Product-->
<div class="product-card product-list">
    <a class="product-thumb" href="{{ url('shop/'.$product->slug) }}">
        @if($product->discount)
            <div class="product-badge text-danger">{{ $product->discount }}% Off</div>
        @endif
        <img class="mx-auto" src="{{ $product->image }}" alt="{{ $product->name }}"
             style="max-height: 90%;width: auto;"/>
    </a>
    <div class="product-info">
        @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
            @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>null])
        @endif
        <h3 class="product-title">
            <a href="{{ url('shop/'.$product->slug) }}">
                {{ $product->name }}
            </a>
        </h3>
        <h4 class="product-price">
            @if($product->discount)
                <del>{{ \Payments::currency($product->regular_price) }}</del>
            @endif
            {!! $product->price !!}
        </h4>
        <p class="hidden-xs-down">
            {!! str_limit(strip_tags($product->description),500) !!}
        </p>
        <div class="product-buttons">
            @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
                @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
            @endif
            @if(!$product->isSimple || $product->attributes()->count())
                @if($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" class="btn btn-outline-primary btn-sm"
                       title="Buy Product">@lang('corals-ecommerce-basic::labels.partial.buy_product')
                    </a>
                @else
                    <a href="{{ url('shop/'.$product->slug) }}" class="btn btn-outline-primary btn-sm">
                        @lang('corals-ecommerce-basic::labels.partial.add_to_cart')
                    </a>
                @endif
            @else
                @php $sku = $product->activeSKU(true); @endphp
                @if($sku->stock_status == "in_stock")
                    @if($product->external_url)
                        <a href="{{ $product->external_url }}" target="_blank" class="btn btn-outline-primary btn-sm"
                           title="Buy Product">@lang('corals-ecommerce-basic::labels.partial.buy_product')
                        </a>
                    @else
                        <a href="{{ url('cart/'.$product->hashed_id.'/add-to-cart/'.$sku->hashed_id) }}"
                           data-action="post" data-page_action="updateCart"
                           class="btn btn-outline-primary btn-sm">
                            @lang('corals-ecommerce-basic::labels.partial.add_to_cart')
                        </a>
                    @endif
                @else
                    <a href="#" class="btn btn-sm btn-outline-danger"
                       title="Out Of Stock">
                        @lang('corals-ecommerce-basic::labels.partial.out_stock')
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>