@extends('layouts.master')

@section('editable_content')
    @php \Actions::do_action('pre_content',$product, null) @endphp

    <section class="container mt-80 product-detail">
        <div class="row">
            <div class="col-lg-5 mt-20">
                <div class="image-box">
                    @if($product->discount)
                        <div class="product-badge text-danger">{{ $product->discount }}% Off</div>
                    @endif
                    @if(!($medias = $product->getMedia('ecommerce-product-gallery'))->isEmpty())
                        <div class="product-carousel owl-carousel text-center">
                            @foreach($medias as $media)
                                <a href="{{ $media->getUrl() }}" data-hash="gItem_{{ $media->id }}"
                                   data-lightbox="product-gallery">
                                    <img src="{{ $media->getUrl() }}" class="mx-auto" alt="Product"
                                         style="max-height: 300px;width: auto;max-width: 300px"/>
                                </a>
                            @endforeach
                        </div>
                            <div class="d-flex flex-wrap product-thumbnails">
                            @foreach($medias as $media)
                                <div class="m-2">
                                    <a href="#gItem_{{ $media->id }}">
                                        <img src="{{ $media->getUrl() }}" alt="Product" class="img-thumbnail"
                                             style="max-height: 100px;width: auto;"></a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7 mt-20">
                <div class="product-data">
                    @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                        @include('partials.components.rating',['rating'=> $product->averageRating(1)[0],'rating_count'=>$product->countRating()[0] ])
                    @endif
                    <h2 class="product-title">{{ $product->name }}</h2>
                    <p class="product-price"> {!! $product->price  !!}</p>
                    <p>{{ $product->caption }}</p>
                    <hr>
                    {!! Form::open(['url'=>'cart/'.$product->hashed_id.'/add-to-cart','method'=>'POST','class'=> 'ajax-form','data-page_action'=>"updateCart"]) !!}
                    @if(!$product->isSimple)
                        @foreach($product->activeSKU as $sku)
                            @if($loop->index%4 == 0)
                                <div class="d-flex flex-wrap">
                                    @endif
                                    <div class="text-center sku-item mr-2" style="width: 240px;">
                                        <img src="{{ asset($sku->image) }}" class="img-responsive img-radio mx-auto"
                                             style="max-height: 100px;">
                                        <div class="middle">
                                            <div class="text text-success"><i class="fa fa-check fa-4x"></i></div>
                                        </div>
                                        <div>
                                            {!! !$sku->options->isEmpty() ? $sku->presenter()['options']:'' !!}
                                        </div>
                                        @if($sku->stock_status == "in_stock")
                                            <button type="button"
                                                    class="btn btn-block btn-sm btn-default btn-radio m-t-5">
                                                <b>{!! $sku->discount?'<del class="text-muted">'.\Payments::currency($sku->regular_price).'</del>':''  !!} {!! currency()->format($sku->price, \Settings::get('admin_currency_code'), currency()->getUserCurrency()) !!}</b>
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="btn btn-primary btn-block btn-sm m-t-5 btn-danger">
                                                <b> Out of stock </b>
                                            </button>
                                        @endif
                                        <input type="checkbox" id="left-item" name="sku_hash"
                                               value="{{ $sku->hashed_id }}"
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
                    <span data-name="sku_hash"></span>
                </div>
                <table class="table table-bordered d-inline-block border-0">
                    <tr>
                        <td>
                            {!! CoralsForm::number('quantity','corals-compo::attributes.template.quantity', false, 1, ['min' => 1,'class'=>'form-control form-control-sm']) !!}
                        </td>
                    </tr>
                </table>

                @if(\Settings::get('ecommerce_wishlist_enable', 'true') == 'true')
                    @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
                @endif

                @if($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" class="btn btn-success btn-sm"
                       title="@lang('corals-compo::labels.template.product_single.buy_product')">
                        <i class="fa fa-fw fa-cart-plus"
                           aria-hidden="true"></i> @lang('corals-compo::labels.template.product_single.buy_product')
                    </a>
                @elseif($product->isSimple && $product->activeSKU(true)->stock_status != "in_stock")
                    <a href="#" class="btn btn-sm btn-outline-danger"
                       title="Out Of Stock">
                        @lang('corals-compo::labels.partial.out_stock')
                    </a>
                @else
                    {!! CoralsForm::button('corals-compo::labels.partial.add_to_cart',
                ['class'=>'btn btn-primary btn-sm'], 'submit') !!}
                @endif

                {{ Form::close() }}
                <hr>
                <h5>@lang('corals-compo::labels.template.product_single.category')</h5>
                <ul class="product-category">
                    <li>
                        @foreach($product->activeCategories as $category)
                            <a class="" href="{{ url('shop?category='.$category->slug) }}"><b>{{ $category->name }}</b></a>
                            &nbsp;&nbsp;
                        @endforeach
                    </li>
                </ul>
                <h5>@lang('corals-compo::labels.template.product_single.tag')</h5>
                @if($product->activeTags->count())
                    <div class="product-tags">
                        @foreach($product->activeTags as $tag)
                            <a class="badge badge-pill badge-light"
                               href="{{ url('shop?tag='.$tag->slug) }}"><b>{{ $tag->name }}</b></a>&nbsp;&nbsp;
                        @endforeach
                    </div>
                @endif
                <div class="">
                    @include('partials.components.social_share',['url'=> URL::current() , 'title'=>$product->name ])
                </div>
            </div>
        </div>
        <div class="row mt-80">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#t1body1" aria-controls="t1body1" role="tab"
                           data-toggle="tab">@lang('corals-compo::labels.template.product_single.description')</a>
                    </li>
                    @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                        <li class="nav-item">
                            <a class="nav-link" href="#reviews" aria-controls="t1body2" role="tab"
                               data-toggle="tab">@lang('corals-compo::labels.template.product_single.reviews',['count'=>$product->ratings->count()])</a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="t1body1">
                        <p>
                            {!! $product->description !!}
                        </p>
                    </div>
                    @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                        @include('partials.tabs.reviews',['reviews'=>$product->ratings])
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('partials.featured_products')
@stop

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection