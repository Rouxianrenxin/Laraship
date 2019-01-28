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

    <div class="container padding-bottom-3x mt-5">
        <div class="row">
            <!-- Poduct Gallery-->
            <div class="col-md-6">
                <div class="product-gallery">
                    @if($product->discount)
                        <span class="product-badge bg-danger">{{ $product->discount }}% Off</span>
                    @endif
                    @if(!($medias = $product->getMedia('ecommerce-product-gallery'))->isEmpty())
                        <div class="product-carousel owl-carousel text-center">
                            @foreach($medias as $media)
                                <a href="{{ $media->getUrl() }}" data-hash="gItem_{{ $media->id }}"
                                   data-lightbox="product-gallery">
                                    <img src="{{ $media->getUrl() }}" class="mx-auto" alt="Product"
                                         style="max-height: 300px;width: auto;"/>
                                </a>
                            @endforeach
                        </div>
                        <ul class="product-thumbnails">
                            @foreach($medias as $media)
                                <li class="{{ $media->getCustomProperty('featured', false)?'active':'' }}">
                                    <a href="#gItem_{{ $media->id }}">
                                        <img src="{{ $media->getUrl() }}" alt="Product"
                                             style="max-height: 100px;width: auto;"></a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center text-muted">
                            <small>@lang('corals-ecommerce-ultimate::labels.template.product_single.image_unavailable')</small>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Product Info-->
            <div class="col-md-6">
                <div class="padding-top-2x mt-2 hidden-md-up"></div>
                @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                    @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>$product->countRating()[0] ])
                @endif
                <h2 class="mb-3">{{ $product->name }}</h2>
                <span class="h3 d-block">
                     @if($product->discount)
                        <del class="text-muted">{{ \Payments::currency($product->regular_price) }}</del>
                    @endif
                    {!! $product->price  !!}
                </span>
                <p class="text-muted">
                    {{ $product->caption }}
                </p>
                <div class="row margin-top-1x">
                </div>
                {!! Form::open(['url'=>'cart/'.$product->hashed_id.'/add-to-cart','method'=>'POST','class'=> 'ajax-form','data-page_action'=>"updateCart"]) !!}
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
                                            <b>{!! $sku->discount?'<del class="text-muted">'.\Payments::currency($sku->regular_price).'</del>':''  !!} {!! currency()->format($sku->price, \Settings::get('admin_currency_code'), currency()->getUserCurrency()) !!}</b>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-block btn-sm m-t-5 btn-danger">
                                            <b> @lang('corals-ecommerce-ultimate::labels.partial.out_stock')</b>
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
            <div class="row align-items-end pb-4">
                <div class="col-sm-4">
                    <div class="no-margin">
                        {!! CoralsForm::number('quantity','corals-ecommerce-ultimate::attributes.template.quantity', false, 1, ['min' => 1,'class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @if($product->globalOptions->count())
                        {!! $product->renderProductOptions('global_options',null, ['class'=>'form-control form-control-sm']) !!}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="pt-4 hidden-sm-up"></div>
                    @if($product->external_url)
                        <a href="{{ $product->external_url }}" target="_blank" class="btn btn-success"
                           title="@lang('corals-ecommerce-ultimate::labels.template.product_single.buy_product')">
                            <i class="fa fa-fw fa-cart-plus"
                               aria-hidden="true"></i> @lang('corals-ecommerce-ultimate::labels.template.product_single.buy_product')
                        </a>
                    @elseif($product->isSimple && $product->activeSKU(true)->stock_status != "in_stock")
                        <a href="#" class="btn btn-sm btn-outline-danger"
                           title="Out Of Stock">
                            @lang('corals-ecommerce-ultimate::labels.partial.out_stock')
                        </a>
                    @else
                        <div class="form-group">
                            {!! CoralsForm::button('corals-ecommerce-ultimate::labels.partial.add_to_cart',
                            ['class'=>'btn btn-primary btn-block m-0'], 'submit') !!}
                        </div>
                    @endif
                </div>
            </div>
            {{ Form::close() }}

            <div class="mb-2">
                <span class="text-medium">@lang('corals-ecommerce-ultimate::labels.template.product_single.category')</span>
                @foreach($product->activeCategories as $category)
                    <a class="" href="{{ url('shop?category='.$category->slug) }}"><b>{{ $category->name }}</b></a>
                    &nbsp;&nbsp;
                @endforeach
            </div>
            @if($product->activeTags->count())
                <div class="padding-bottom-1x mb-2">
                    <span class="text-medium">@lang('corals-ecommerce-ultimate::labels.template.product_single.tag')</span>
                    @foreach($product->activeTags as $tag)
                        <a class="" href="{{ url('shop?tag='.$tag->slug) }}"><b>{{ $tag->name }}</b></a>&nbsp;&nbsp;
                    @endforeach
                </div>
            @endif

            <hr class="mb-2">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="product mt-2 mb-2">

                    @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
                        @include('partials.components.wishlist_product',['wishlist'=> $product->inWishList() ])
                    @endif
                </div>
                <div class="mt-2 mb-2"><span
                            class="text-muted">@lang('corals-ecommerce-ultimate::labels.template.product_single.share')</span>
                    <div class="d-inline-block">
                        @include('partials.components.social_share',['url'=> URL::current() , 'title'=>$product->name ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details-->
    <div class="padding-top-3x padding-bottom-2x mb-3" id="details" style="margin-top: 20px">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#description" data-toggle="tab"
                                                role="tab">@lang('corals-ecommerce-ultimate::labels.template.product_single.description')</a>
                        </li>
                        @if(\Settings::get('ecommerce_rating_enable',true) === 'true')

                            <li class="nav-item"><a class="nav-link" href="#reviews" data-toggle="tab"
                                                    role="tab">{{ trans('corals-ecommerce-ultimate::labels.template.product_single.reviews',['count'=>$product->ratings->count()]) }}</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div>
                                {!! $product->description !!}
                            </div>
                        </div>
                        @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                            <br>
                            @include('partials.tabs.reviews',['reviews'=>$product->ratings])
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.featured_products_slider',['title'=>trans('corals-ecommerce-ultimate::labels.template.product_single.title')])
@stop

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection