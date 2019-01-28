<div class="card product-grid-box">
    <div class="card-body">
        <div class="head">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="mx-auto img-fluid"
                 style="max-height: 150px;width: auto;">
            @if($product->discount)
                <div class="product-badge">{{ $product->discount }}% Off</div>
            @endif
        </div>
        <div class="body">
            <a class="product-title" href="{{ url('shop/'.$product->slug) }}">{{ str_limit($product->name , 45) }} </a>
            <p class="product-price">
                @if($product->discount)
                    <del>{{ \Payments::currency($product->regular_price) }}</del>
                @endif
                {!! $product->price !!}
            </p>
            <span class="product-rating">
                   @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                    @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>null])
                @endif
                </span>
            <div class="product-buttons">
                @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
                    @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
                @endif
                @if(!$product->isSimple || $product->attributes()->count())
                    @if($product->external_url)
                        <a href="{{ $product->external_url }}" target="_blank" class="btn btn-outline-primary btn-sm"
                           title="Buy Product">
                            @lang('corals-compo::labels.partial.buy_product')
                        </a>
                    @else
                        <a href="{{ url('shop/'.$product->slug) }}" class="btn btn-primary btn-sm">
                            @lang('corals-compo::labels.partial.add_to_cart')
                        </a>
                    @endif
                @else
                    @php $sku = $product->activeSKU(true); @endphp
                    @if($sku->stock_status == "in_stock")
                        @if($product->external_url)
                            <a href="{{ $product->external_url }}" target="_blank"
                               class="btn btn-outline-primary btn-sm"
                               title="Buy Product">
                                @lang('corals-compo::labels.partial.buy_product')
                            </a>
                        @else
                            <a href="{{ url('cart/'.$product->hashed_id.'/add-to-cart/'. $sku->hashed_id) }}"
                               data-action="post" data-page_action="updateCart"
                               class="btn btn-primary btn-sm">@lang('corals-compo::labels.partial.add_to_cart')
                            </a>
                        @endif
                    @else
                        <a href="#" class="btn btn-sm btn-outline-danger" title="Out Of Stock">
                            <i class="fa fa-shopping-cart"></i>
                            @lang('corals-compo::labels.partial.out_stock')
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

