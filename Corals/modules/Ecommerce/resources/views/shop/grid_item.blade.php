@component('components.box')
    <div class="col-md-12 col-sm-12 col-xs-12 image-main-section">
        <a class="text-center" href="{{ url('e-commerce/shop/'.$item->slug) }}" title="View Product" style="display: block;">
            <img class="img-fluid img-rounded" style="max-height: 200px;" width="auto"
                 src="{{ asset($item->image) }}"
                 alt="Product Image">
            <h4><b>{!! $item->present('plain_name') !!}</b></h4>
        </a>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <h5 class="text-left">
            {!! str_limit($item->caption,50) !!}
        </h5>
        <div class="row">
            <div class="col-md-6 text-left col-xs-12 text-green">
                <p class="lead">{!! $item->price !!}</p>
            </div>
            <div class="col-xs-12 col-md-6 text-right">
                @if(!$item->isSimple || $item->attributes()->count())
                    @if($item->external_url)
                        <a href="{{ $item->external_url }}" target="_blank" class="btn btn-success"
                           title="Buy Product">
                            <i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i> @lang('Ecommerce::labels.shop.buy')
                        </a>
                    @else
                        <a href="{{ url('e-commerce/shop/'.$item->slug) }}" class="btn btn-success"
                           title="Add to Cart">
                            <i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i> @lang('Ecommerce::labels.shop.add')
                        </a>
                    @endif
                @else
                    @if($item->activeSKU(true)->stock_status == "in_stock")
                        @if($item->external_url)
                            <a href="{{ $item->external_url }}" target="_blank" class="btn btn-success"
                               title="Buy Product">
                                <i class="fa fa-fw fa-cart-plus"
                                   aria-hidden="true"></i> @lang('Ecommerce::labels.shop.buy')
                            </a>
                        @else
                            <a href="{{ url('cart/'.$item->hashed_id.'/add-to-cart/'.$item->activeSKU(true)->hashed_id) }}"
                               class="btn btn-success"
                               title="@lang('Ecommerce::labels.shop.add')" data-action="post"
                               data-page_action="updateCart">
                                <i class="fa fa-fw fa-cart-plus"
                                   aria-hidden="true"></i> @lang('Ecommerce::labels.shop.add')
                            </a>
                        @endif
                    @else
                        <a href="#" class="btn btn-danger"
                           title="@lang('Ecommerce::labels.shop.out_stock')">
                            @lang('Ecommerce::labels.shop.out_stock')
                        </a>
                    @endif

                @endif
            </div>
        </div>
    </div>
@endcomponent