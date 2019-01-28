@extends('layouts.theme')

@section('hero_area')
    @include('partials.page_header')
@endsection

@section('editable_content')
    <div class="section-padding">
        <div class="container">
            <div class="product-info row">
                <div class="col-lg-7 col-md-12 col-xs-12">
                    <div class="details-box ads-details-wrapper">
                        <div id="owl-product-show" class="owl-carousel owl-theme image-set">
                            @forelse($product->getMedia($product->galleryMediaCollection) as $img)
                                <div class="item">
                                    <a class="product-img" href="{{$img->getUrl() }}" data-lightbox="image-set">
                                        <img src="{{ $img->getUrl() }}"
                                             class="img-fluid"
                                             alt="{{ $product->name }}"/>
                                    </a>
                                    @if($loop->first)
                                        <span class="price">{{ $product->present('price') }}</span>
                                    @endif
                                </div>
                            @empty
                                <img src="{{ $product->image }}"
                                     class="img-fluid"
                                     alt="{{ $product->name }}"/>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 col-xs-12">
                    <div class="details-box">
                        <div class="ads-details-info">
                            <h2>{{ $product->name }}</h2>
                            <p class="mb-2">{{ $product->caption }}</p>
                            <div class="details-meta">
                                <span data-toggle="tooltip" data-placement="top"
                                      title="{{$product->present('created_at')}}">
                                    <a href="#"><i class="lni-alarm-clock"></i>{{$product->created_at->diffForHumans()}}</a></span>
                                <span><a href="{{url('products?location='.$product->location->slug)}}"><i
                                                class="lni-map-marker"></i>{{$product->location->name}}</a></span>
                                <div class="product-category">
                                    @foreach($product->activeCategories as $category)
                                        <a href="{{url('products?category='.$category->slug)}}"><i
                                                    class="lni-folder"></i> {!! $category->name !!}</a>
                                    @endforeach
                                    @foreach($product->activeTags as $tag)
                                        <span><i class="lni-tag"></i> {!! $tag->name !!} </span>
                                    @endforeach
                                </div>
                            </div>
                            @if(!($product->options)->isEmpty())
                                <h4 class="title-small my-3">@lang('corals-classified-master::labels.template.product.specification')</h4>
                                <ul class="list-specification">
                                    @foreach($product->options as $option)
                                        <li><i class="lni-check-mark-circle"></i> {{ $option->attribute->label }}:
                                            {{ $option->formattedValue }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <ul class="advertisement mb-4">
                            @if(!empty($product->condition))
                                <li>
                                    <p><strong>@lang('corals-classified-master::labels.template.product.condition')</strong> <a
                                                href="{{url('products?condition='.$product->condition)}}">{{ $product->present('condition') }}</a>
                                    </p>
                                </li>
                            @endif
                            @if(!empty($product->brand))
                                <li>
                                    <p><strong>@lang('corals-classified-master::labels.template.product.brand')</strong> <a
                                                href="#">{{$product->brand}}</a></p>
                                </li>
                            @endif
                        </ul>
                        <div class="ads-btn mb-4">
                            @if(\Settings::get('classified_messaging_is_enable',true) && (!user() || user()->can('create', Corals\Modules\Messaging\Models\Discussion::class)))
                                <a href="{{ url('messaging/discussions/create?user='.$product->user->hashed_id) }}" class="btn btn-common btn-reply"><i
                                            class="lni-envelope"></i></a>
                            @else
                                <a href="mailto:{{$product->user->email}}" class="btn btn-common btn-reply"><i
                                            class="lni-envelope"></i></a>
                            @endif
                            @if(!empty($product->user->phone))
                                <a href="#" class="btn btn-common call">
                                    <i class="lni-phone-handset"></i>
                                    <span class="phonenumber">{{$product->user->phone}}</span></a>
                            @endif
                            @if(\Settings::get('classified_wishlist_enable',true))
                                @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
                            @endif
                        </div>
                        <div class="share">
                            <span>@lang('corals-classified-master::labels.template.product.share')</span>
                            @include('partials.components.social_share',['url'=> URL::current() , 'title'=>$product->name ])
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Info End -->

            <!-- Product Description Start -->
            <div class="description-info">
                <div class="row">
                    <div class="col-lg-8 col-md-6 col-xs-12">
                        <div class="description">
                            <h5>@lang('corals-classified-master::labels.template.product.description')</h5>
                            <hr/>
                            <div>
                                @if(!empty($product->description))
                                    {!! $product->description !!}
                                @else
                                    @lang('corals-classified-master::labels.product.not_available')
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="short-info">
                            <h5>Short Info</h5>
                            <hr/>
                            <ul>
                                <li><a href="{{url('products?user='.$product->user->hashed_id)}}"><i
                                                class="lni-users"></i> {!!  trans('corals-classified-master::labels.template.product.more_products_by',['name'=>$product->user->full_name]) !!}
                                    </a></li>
                                <li><a href="javascript: w=window.print()"><i
                                                class="lni-printer"></i> @lang('corals-classified-master::labels.template.product.print')
                                    </a></li>
                                <li><a href="#" data-toggle="modal" data-target="#ProductRefertModal"><i
                                                class="lni-reply"></i>@lang('corals-classified-master::labels.template.product.friend_send')
                                    </a></li>
                                <li><a href="#" data-toggle="modal" data-target="#ProductReportModal"><i
                                                class="lni-warning"></i> @lang('corals-classified-master::labels.template.product.report')
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Description End -->
        </div>
    </div>
    @include('partials.report_modal',['product' => $product])
    @include('partials.refer_modal',['product' => $product])

    @include('partials.featured_products')
@endsection
