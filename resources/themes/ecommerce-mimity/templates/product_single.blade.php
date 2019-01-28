@extends('layouts.master')

@section('css')
    <style type="text/css">
        .sku-item {
            position: relative;
        }

        .sku-item .badge {
            font-size: 75%;
            /*width: 100%;*/
        }

        .img-radio {
            max-height: 100px;
            margin: 5px auto;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .selected-radio > img {
            opacity: .45;
        }

        .selected-radio .middle {
            opacity: 1;
        }

        .product .btn-cart > span {
            font-size: 15px;
            opacity: 1;
            top: 10px;
            justify-content: center;
        }

        .product .ladaa > span > span {
            font-size: 12px;
            white-space: nowrap;
            opacity: 1;
            padding-left: 3px;
            color: black;
        }

        .product .ladaa > span > i {
            color: black;
        }

        .product .product-button:hover > i {
            -webkit-transform: translateY(-10px);
            -ms-transform: translateY(-10px);
            transform: translateY(-10px);
        }

        .product .product-button:hover > span, .product .ladaa:hover > span > span {
            -webkit-transform: translateY(0);
            -ms-transform: translateY(0);
            transform: translateY(0);
            opacity: 1;
        }

        .product .ladaa.active > span > i, .product .btn-wishlist.active > span > i {
            color: #f44336;
        }
    </style>
@endsection

@section('editable_content')
    @php \Actions::do_action('pre_content',$product, null) @endphp

    <div class="row">
        <div class="col-md-7">
            <div class="img-detail-wrapper">
                <img src="{{ $product->image }}" class="img-fluid px-5" id="img-detail" alt="Responsive image"
                     data-index="0">
                <div class="img-detail-list">
                    @if(!($medias = $product->getMedia('ecommerce-product-gallery'))->isEmpty())
                        @foreach($medias as $media)
                            <a href="#" class="active"><img src="{{ $media->getUrl() }}"
                                                            data-large-src="{{ $media->getUrl() }}" alt="Product"
                                                            data-index="0"></a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="detail-header">
                <h3>{{ $product->name }}</h3>
                <h6>
                    @if(\Settings::get('ecommerce_rating_enable','true') === 'true')
                        @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>$product->countRating()[0] ])
                    @endif
                </h6>
                <h3 class="price">{!! $product->price !!}</h3>
                <p class=" text-normal">{{ $product->caption }}</p>
            </div>
            {!! Form::open(['url'=> 'cart/'.$product->hashed_id.'/add-to-cart','method'=>'POST','class'=> 'ajax-form','data-page_action'=>"updateCart"]) !!}
            @if(!$product->isSimple)
                @foreach($product->activeSKU as $sku)
                    @if($loop->index%4 == 0)
                        <div class="d-flex flex-wrap">
                            @endif
                            <div class="text-center sku-item mr-2" style="width: 240px;">
                                <img src="{{ asset($sku->image) }}" class="img-responsive img-radio mx-auto">
                                <div class="middle">
                                    <div class="text text-success"><i class="fa fa-check fa-4x"></i></div>
                                </div>
                                <div>
                                    {!! !$sku->options->isEmpty() ? $sku->presenter()['options']:'' !!}
                                </div>
                                @if($sku->stock_status == "in_stock")
                                    <button type="button"
                                            class="btn btn-block btn-sm btn-default btn-secondary btn-radio m-t-5">
                                        <b>{!! $sku->discount?'<del class="text-muted">'.\Payments::currency($sku->regular_price).'</del>':''  !!} {!! \Payments::currency($sku->price) !!}</b>
                                    </button>
                                @else
                                    <button type="button"
                                            class="btn btn-block btn-sm m-t-5 btn-danger">
                                        <b> @lang('corals-ecommerce-mimity::labels.partial.out_stock')</b>
                                    </button>
                                @endif
                                <input type="checkbox" id="left-item" name="sku_hash" value="{{ $sku->hashed_id }}"
                                       class="hidden d-none disable-icheck"/>
                            </div>
                            @if($lastLoop = $loop->index%4 == 3)
                        </div>
                    @endif
                @endforeach
                @if(!$lastLoop)</div>@endif
        <div class="form-group">
            <span data-name="sku_hash"></span>
        </div>
        @else
            <input type="hidden" name="sku_hash" value="{{ $product->activeSKU(true)->hashed_id }}"/>
        @endif
        <div class="form-group">
            <div class="input-spinner">
                {!! CoralsForm::number('quantity','corals-ecommerce-mimity::attributes.template.quantity', false, 1, ['min' => 1,'class'=>'form-control form-control-sm']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="btn-group-sm btn-group-toggle" data-toggle="buttons">
                @if($product->globalOptions->count())
                    {!! $product->renderProductOptions('global_options',null, ['class'=>'form-control form-control-sm']) !!}
                @endif
            </div>
        </div>
        <div class="form-group">
            @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
                @include('partials.components.wishlist',['wishlist'=> $product->inWishList()])
            @endif
            @if(!$product->isSimple || $product->attributes()->count())
                @if($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" class="btn btn-info btn-block"
                       title="Buy Product">
                        @lang('corals-ecommerce-mimity::labels.partial.buy_product')
                    </a>
                @else
                    <a href="{{ url('shop/'.$product->slug) }}" class="btn btn-info btn-block">
                        @lang('corals-ecommerce-mimity::labels.partial.add_to_cart')
                    </a>
                @endif
            @else
                @php $sku = $product->activeSKU(true); @endphp
                @if($sku->stock_status == "in_stock")
                    @if($product->external_url)
                        <a href="{{ $product->external_url }}" target="_blank"
                           class="btn btn-info btn-block"
                           title="Buy Product">
                            @lang('corals-ecommerce-mimity::labels.partial.buy_product')
                        </a>
                    @else
                        <a href="{{ url('cart/'.$product->hashed_id.'/add-to-cart/'.$sku->hashed_id) }}"
                           data-action="post" data-page_action="updateCart"
                           class="btn btn-info btn-block m-t-10">
                            @lang('corals-ecommerce-mimity::labels.partial.add_to_cart')
                        </a>
                    @endif
                @else
                    <a href="#" class="btn btn-info btn-block btn-outline-danger"
                       title="Out Of Stock">
                        @lang('corals-ecommerce-mimity::labels.partial.out_stock')
                    </a>
                @endif
            @endif
        </div>
        {{ Form::close() }}
        <div class="mb-2">
            <span class="text-medium">@lang('corals-ecommerce-mimity::labels.template.product_single.category')</span>
            @foreach($product->activeCategories as $category)
                <a class="" href="{{ url('shop?category='.$category->slug) }}"><b>{{ $category->name }}</b></a>
                &nbsp;&nbsp;
            @endforeach
        </div>
        @if($product->activeTags->count())
            <div class="padding-bottom-1x mb-2">
                <span class="text-medium">@lang('corals-ecommerce-mimity::labels.template.product_single.tag')</span>
                @foreach($product->activeTags as $tag)
                    <a class="" href="{{ url('shop?tag='.$tag->slug) }}"><b>{{ $tag->name }}</b></a>&nbsp;&nbsp;
                @endforeach
            </div>
        @endif
        <hr class="mb-3">
        <div class="d-flex flex-wrap justify-content-between">
            @include('partials.components.social_share',['url'=> URL::current() , 'title'=>$product->name ])

        </div>
    </div></div>
    <hr>
    <div class="row mt-4">
        <div class="col">
            <h3>@lang('corals-ecommerce-mimity::labels.template.product_single.description')</h3>
            {!! $product->description !!}
            @include('partials.featured_products',['title'=>trans('corals-ecommerce-mimity::labels.template.product_single.title')])
            <hr>
            @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                <br>
                @include('partials.tabs.reviews',['reviews'=>$product->ratings])
            @endif
        </div>
    </div>
    <!-- Photoswipe container-->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection