<div class="col-6 col-md-3 mb-2">
    <div class="card card-product p-1">
        @if($product->discount)
            <div class="ribbon"><span class="bg-info text-white">{{ $product->discount }} %off</span></div>
        @endif
        @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
            @include('partials.components.wishlist',['wishlist'=> $product->inWishList()])
        @endif
        <a href="{{ url('shop/'.$product->slug) }}" class="text-center"><img src="{{ $product->image }}"
                                                                             alt="{{ $product->name }}"
                                                                             class="card-img-top"></a>
        <div class="card-body">
            @if($product->discount)
                <del class="small text-muted">{{ \Payments::currency($product->regular_price) }}</del>
            @endif
            <span class="price">{!! $product->price !!}</span>
            <a href="{{ url('shop/'.$product->slug) }}" class="card-title h6">{{ $product->name }}</a>
            <div class="d-flex justify-content-between align-items-center">
                @if(\Settings::get('ecommerce_rating_enable','true') === 'true')
                    @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>null])
                @endif
                @if(!$product->isSimple || $product->attributes()->count())
                    @if($product->external_url)
                        <a href="{{ $product->external_url }}" target="_blank" class="btn btn-outline-primary btn-sm"
                           title="Buy Product">
                            @lang('corals-ecommerce-mimity::labels.partial.buy_product')
                        </a>
                    @else
                        <a href="{{ url('shop/'.$product->slug) }}" class="btn btn-outline-info btn-sm btn-block">
                            @lang('corals-ecommerce-mimity::labels.partial.add_to_cart')
                        </a>
                    @endif
                @else
                    @php $sku = $product->activeSKU(true); @endphp
                    @if($sku->stock_status == "in_stock")
                        @if($product->external_url)
                            <a href="{{ $product->external_url }}" target="_blank"
                               class="btn btn-outline-primary btn-sm btn-block"
                               title="Buy Product">
                                @lang('corals-ecommerce-mimity::labels.partial.buy_product')
                            </a>
                        @else
                            <a href="{{ url('cart/'.$product->hashed_id.'/add-to-cart/'.$sku->hashed_id) }}"
                               data-action="post" data-page_action="updateCart"
                               class="btn btn-outline-primary btn-sm">
                                @lang('corals-ecommerce-mimity::labels.partial.add_to_cart')
                            </a>
                        @endif
                    @else
                        <a href="#" class="btn btn-sm btn-outline-danger"
                           title="Out Of Stock">
                            @lang('corals-ecommerce-mimity::labels.partial.out_stock')
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
