@extends('layouts.theme')

@section('editable_content')

    <div class="content">
        <!--  section  -->
        <section class="parallax-section single-par list-single-section" data-scrollax-parent="true" id="sec1">
            <div class="bg par-elem " data-bg="{{$listing->image}}"
                 data-scrollax="properties: { translateY: '30%' }"></div>
            <div class="overlay"></div>
            <div class="bubble-bg"></div>
            <div class="list-single-header absolute-header fl-wrap">
                <div class="container">
                    <div class="list-single-header-item">
                        <div class="list-single-header-item-opt fl-wrap">
                            @foreach($listing->categories as $category)
                                <div class="list-single-header-cat fl-wrap">
                                    <a href="{{url('listings?category='.$category->slug)}}">{{$category->name}}</a>
                                </div>
                            @endforeach

                        </div>
                        <h2>{{$listing->name}}
                            @if($listing->user)
                                <span> - @lang('corals-directory-basic::labels.template.product_single.added_by') </span>
                                <a href="{{ url('listings?user='.$listing->user->hashed_id) }}">
                                    {{ $listing->user->name }}</a>
                            @endif
                        </h2>
                        <span class="section-separator"></span>
                        @if(\Settings::get('directory_rating_enable',true))
                            @include('partials.components.rating',['rating'=> $listing->averageRating(1)[0],'rating_count'=>$listing->countRating()[0] ])
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-single-header-contacts fl-wrap">
                                <ul>
                                    @if($listing->getProperty('contact_info.phone_number') )
                                        <li><i class="fa fa-phone"></i><a
                                            >{{$listing->getProperty('contact_info.phone_number') }}</a>
                                        </li>
                                    @endif
                                    <li><i class="fa fa-map-marker"></i><a>{{$listing->location->name}}</a>
                                    </li>
                                    @if($listing->getProperty('contact_info.email'))
                                        <li><i class="fa fa-envelope-o"></i><a
                                                    href="mailto:{{$listing->getProperty('contact_info.email') }}">{{$listing->getProperty('contact_info.email') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fl-wrap list-single-header-column">
                                <div class="share-holder hid-share">
                                    <div class="showshare">
                                        <span>@lang('corals-directory-basic::labels.template.product_single.share') </span><i
                                                class="fa fa-share"></i></div>
                                    <div class="share-container  isShare"></div>
                                </div>
                                @if(\Settings::get('directory_rating_enable',true))
                                    <a class="custom-scroll-link" href="#sec5"><i
                                                class="fa fa-hand-o-right"></i>@lang('corals-directory-basic::labels.template.product_single.add_review')
                                    </a>
                                @endif
                                @if(empty($listing->user_id))
                                    @if(!user())
                                        <a class="custom-link" href="{{ url('login') }}">
                                            <i class="fa fa-paperclip">
                                            </i>@lang('Directory::attributes.claim.listing_claim')
                                        </a>
                                    @else
                                        @can('create', Corals\Modules\Directory\Models\Claim::class)
                                        <a href="#" class="custom-link" data-toggle="modal"
                                           data-target="#listing_claim"><i
                                                    class="fa fa-paperclip"></i>@lang('Directory::attributes.claim.listing_claim')
                                        </a>
                                        @endcan
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--  section end -->
    <div class="scroll-nav-wrapper fl-wrap">
        <div class="container">
            <nav class="scroll-nav scroll-init">
                <ul>
                    <li><a class="act-scrlink"
                           href="#sec1">@lang('corals-directory-basic::labels.template.product_single.top')</a></li>
                    <li><a href="#sec2">@lang('corals-directory-basic::labels.template.product_single.details')</a></li>
                    <li><a href="#sec3">@lang('corals-directory-basic::labels.template.product_single.gallery')</a></li>
                    <li>
                        <a href="#sec4">@lang('corals-directory-basic::labels.template.product_single.reviews',['count'=>$listing->ratings->count()])</a>
                    </li>
                </ul>
            </nav>
            @if(\Settings::get('directory_wishlist_enable',true))
                @include('partials.components.wishlist_product',['wishlist'=> $listing->inWishList() ])
            @endif
        </div>
    </div>
    <!--  section  -->
    <section class="gray-section no-top-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="list-single-main-wrapper fl-wrap" id="sec2">
                        <div class="breadcrumbs gradient-bg  fl-wrap"><a
                                    href="{{url('/')}}">@lang('corals-directory-basic::labels.template.product_single.home')</a><a
                                    href="{{url('/listings')}}">Listings</a><span>{{$listing->name}}</span>
                        </div>
                        <div class="list-single-main-item fl-wrap">
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>@lang('corals-directory-basic::labels.template.product_single.about') {{$listing->name}} </h3>
                            </div>
                            <p>{!!  $listing->description!!}</p>

                            <span class="fw-separator"></span>
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>@lang('corals-directory-basic::labels.template.product_single.amenities')</h3>
                            </div>
                            <div class="listing-features fl-wrap">
                                <ul>
                                    @foreach($listing->options as $option)
                                        <li><i class=""></i> {{$option->attribute->label}}:{{ $option->formattedValue }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <span class="fw-separator"></span>
                            @if(!$listing->tags->isEmpty())
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>@lang('corals-directory-basic::labels.template.product_single.tag')</h3>
                                </div>
                            @endif
                            <div class="list-single-tags tags-stylwrap">
                                @foreach($listing->tags as $tag)
                                    <a href="#">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="list-single-facts fl-wrap gradient-bg">
                            <!-- inline-facts -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts">
                                    <i class="fa fa-male"></i>
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <span class="num" data-content="0" data-num="{{$listing->visitors_count}}">
                                                0
                                            </span>
                                            <h6>@lang('corals-directory-basic::labels.template.product_single.new_visiters_every_week')</h6>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts">
                                    <i class="fa {{ $listing->is_featured ? 'fa-diamond': 'fa-th-list' }}"></i>
                                    <div class="milestone-counter">
                                        <h6>{{ $listing->is_featured ? trans('corals-directory-basic::labels.template.product_single.featured') :  trans('corals-directory-basic::labels.template.product_single.non_featured') }} </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts">
                                    <i class="fa {{ $listing->verified ? 'fa-check': 'fa-question' }}"></i>
                                    <div class="milestone-counter">
                                        <h6>{{ $listing->verified ? trans('corals-directory-basic::labels.template.product_single.verified') :  trans('corals-directory-basic::labels.template.product_single.non_verified') }} </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                        </div>
                        <div class="list-single-main-item fl-wrap" id="sec3">
                            <div class="list-single-main-item-title fl-wrap">
                                <h3>@lang('corals-directory-basic::labels.template.product_single.gallery_photos')</h3>
                            </div>
                            <!-- gallery-items   -->
                            <div id="owl-product-show"
                                 class="gallery-items grid-small-pad  list-single-gallery three-coulms lightgallery owl-carousel owl-theme image-set">
                                @foreach($listing->getMedia($listing->galleryMediaCollection) as $img)
                                    <div class="gallery-item">
                                        <div class="grid-item-holder">
                                            <a href="{{$img->getUrl() }}"
                                               data-lightbox="image-set">
                                                <div class="box-item">
                                                    <img src="{{$img->getUrl()}}" alt="{{$listing->name}}">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- end gallery items -->
                        </div>
                        <!-- list-single-main-item end -->
                        <!-- list-single-main-item -->
                        <div class="list-single-main-item fl-wrap" id="sec4">
                            @if(\Settings::get('directory_rating_enable',true))
                                @include('partials.rating_form')
                            @endif
                            @if(!($ratings = $listing->ratings('approved')->get())->isEmpty())
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>@lang('corals-directory-basic::labels.template.product_single.reviews',['count'=> $ratings->count() ])
                                    </h3>
                                </div>
                                <div class="reviews-comments-wrap">
                                    @foreach($ratings as $review)
                                        @include('partials.rating_single',['review'=> $review ,'show_name'=>false,'show_status'=>false  ])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!--box-widget-wrap -->
                <div class="col-md-4">
                    <div class="box-widget-wrap">
                        <!--box-widget-item -->
                        <div class="box-widget-item fl-wrap">
                            <div class="box-widget-item-header">
                                <h3>@lang('corals-directory-basic::labels.template.product_single.working_hours'): </h3>
                            </div>
                            <div class="box-widget opening-hours">
                                <div class="box-widget-content">
                                <span class="current-status  {{$listing->isOpen()?'':'status-closed'}}"><i
                                            class="fa fa-clock-o"></i>{{$listing->isOpen()?'Now Open':'Closed'}}</span>
                                    <ul>
                                        @foreach($schdule as $key =>$day)

                                            <li><span class="opening-hours-day">{{$key}}</span><span
                                                        class="opening-hours-time  {{$day['start']=='Off'?'status-closed':''}}">{{$day['start']=='Off'?'Off':date("g:i a", strtotime($day['start'].":00"))}}
                                                    {{ $day['end']=='Off'?'':'- '.date("g:i a", strtotime($day['end'].":00"))}}
                                                        </span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--box-widget-item end -->
                        @if(!empty($listing->user_id))
                        <!--box-widget-item -->
                            <div class="box-widget-item fl-wrap">
                                <div class="box-widget-item-header">
                                    <h3>@lang('corals-directory-basic::labels.template.product_single.contact_with',['name' => $listing->name ] )</h3>
                                </div>
                                <div class="box-widget opening-hours">
                                    <div class="box-widget-content contact">
                                        <div id="form_status" class=" alert alert-success"
                                             style="display: none;font-weight:bold;text-align:center"></div>
                                         @if(\Settings::get('directory_messaging_is_enable',true) && (!user() || user()->can('create', Corals\Modules\Messaging\Models\Discussion::class)))
                                            <a href="{{ url('messaging/discussions/create?user='.$listing->user->hashed_id) }}" class="btn big-btn color-bg flat-btn">@lang('corals-directory-basic::labels.template.product_single.send_message')
                                                <i class="fa fa-angle-right"></i></a>
                                         @else
                                            <form class="add-comment custom-form ajax-form" id="main-contact-form"
                                                  name="contact-form"
                                                  action="{{url('directory/listings/contact')}}" method="POST"
                                                  data-page_action="clearForm">
                                                <fieldset>
                                                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                                                    <input type="hidden" value="{{$listing->name}}" name="listing_name">
                                                    <input type="hidden"
                                                           value="{{$listing->getProperty('contact_info.email') }}"
                                                           name="listing_email">
                                                    <label><i class="fa fa-user-o"></i></label>
                                                    <div class="form-group">
                                                        <input type="text"
                                                               placeholder="@lang('corals-directory-basic::labels.template.product_single.your_name') *"
                                                               value="" name="name"/>

                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <label><i class="fa fa-envelope-o"></i> </label>
                                                    <div class="form-group">
                                                        <input type="text"
                                                               placeholder="@lang('corals-directory-basic::labels.template.product_single.your_email')*"
                                                               value="" name="email"/>
                                                    </div>

                                                    <div class="form-group">
                                                     <textarea cols="40" rows="3"
                                                               placeholder="@lang('corals-directory-basic::labels.template.product_single.additional_information'):"
                                                               name="message"></textarea>
                                                    </div>

                                                </fieldset>
                                                <button type="submit"
                                                        class="btn  big-btn  color-bg flat-btn">@lang('corals-directory-basic::labels.template.product_single.send_message')
                                                    <i class="fa fa-angle-right"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--box-widget-item end -->
                        @endif
                    <!--box-widget-item -->
                        <div class="box-widget-item fl-wrap">
                            <div class="box-widget-item-header">
                                <h3>@lang('corals-directory-basic::labels.template.product_single.location')
                                    / @lang('corals-directory-basic::labels.template.product_single.contact') : </h3>
                            </div>
                            <div class="box-widget">
                                <div class="map-container">
                                    <div id="singleMap" data-latitude="{{$listing->location->lat}}"
                                         data-longitude="{{$listing->location->long}}"
                                         data-mapTitle="Our Location"></div>
                                </div>
                                <div class="box-widget-content">
                                    <div class="list-author-widget-contacts list-item-widget-contacts">
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-map-marker"></i> @lang('corals-directory-basic::labels.template.product_single.address')
                                                    :</span> <a>{{$listing->address }}</a></li>
                                            @if($listing->getProperty('contact_info.phone_number'))
                                                <li>
                                                <span><i class="fa fa-phone"></i> @lang('corals-directory-basic::labels.template.product_single.phone')
                                                    :</span>
                                                    <a>{{$listing->getProperty('contact_info.phone_number')}}</a>
                                                </li>
                                            @endif
                                            @if($listing->getProperty('contact_info.email'))
                                                <li>
                                                <span><i class="fa fa-envelope-o"></i> @lang('corals-directory-basic::labels.template.product_single.email')
                                                    :</span> <a
                                                            href="mailto:{{$listing->getProperty('contact_info.email') }}">{{$listing->getProperty('contact_info.email') }}</a>
                                                </li>
                                            @endif

                                            @if($listing->website)
                                                <li>
                                                <span><i class="fa fa-globe"></i> @lang('corals-directory-basic::labels.template.product_single.website')
                                                    :</span> <a target="_blank"
                                                                href="{{$listing->website}}">{{$listing->website}}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="list-widget-social">
                                        <ul>
                                            @if($listing->getProperty('social.facebook'))
                                                <li>
                                                    <a href="{{ $listing->getProperty('social.facebook')  }}"
                                                       target="_blank"><i class="fa fa-facebook"></i></a></li>
                                            @endif
                                            @if($listing->getProperty('social.twitter'))
                                                <li><a href="{{ $listing->getProperty('social.twitter')  }}"
                                                       target="_blank"><i class="fa fa-twitter"></i></a></li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--box-widget-item end -->
                        <!--box-widget-item -->
                        @if($listing->user)
                            <div class="box-widget-item fl-wrap">
                                <div class="box-widget-item-header">
                                    <h3>@lang('corals-directory-basic::labels.template.product_single.added_by') : </h3>
                                </div>
                                <div class="box-widget list-author-widget">
                                    <div class="list-author-widget-header shapes-bg-small  color-bg fl-wrap">
                                        <span class="list-author-widget-link"><a
                                                    href="{{ url('listings?user='.$listing->user->hashed_id) }}">{{$listing->user->full_name}}</a></span>
                                        <img src="{{$listing->user->picture_thumb}}" alt="">
                                    </div>
                                    <div class="box-widget-content">
                                        <div class="list-author-widget-text">
                                            <div class="list-author-widget-contacts">
                                                <ul>
                                                    @if($listing->user->phone)
                                                        <li>
                                                    <span><i class="fa fa-phone"></i> @lang('corals-directory-basic::labels.template.product_single.phone')
                                                        :</span> <a
                                                            >{{$listing->user->phone}}</a>
                                                        </li>
                                                    @endif
                                                    @if($listing->user->email)
                                                        <li>
                                                    <span><i class="fa fa-envelope-o"></i> @lang('corals-directory-basic::labels.template.product_single.email')
                                                        :</span> <a
                                                                    href="mailto:{{$listing->user->email}}">{{$listing->user->email}}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <a href="{{ url('listings?user='.$listing->user->hashed_id) }}"
                                               class="btn transparent-btn">@lang('corals-directory-basic::labels.template.product_single.view_profile')
                                                <i
                                                        class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    <!--box-widget-item end -->
                    </div>
                </div>
            </div>
            <!--box-widget-wrap end -->
        </div>
    </section>
    <!--  section end -->
    <div class="limit-box fl-wrap"></div>
    <!--  section  -->
    @if(!user())
        @include('partials.join_our_community')
    @endif

    <!-- Modal -->
    <div class="listing_claim modal" id="listing_claim">
        <div class="main-overlay"></div>
        <div class="main-register-holder">
            <div class="main-register fl-wrap">
                <div class="close-reg"><i class="fa fa-times"></i></div>
                <h3>@lang('Directory::attributes.claim.listing_claim')</h3>

                <div id="tabs-container">
                    <div class="custom-form">
                        {!! Form::open( ['url' => url('directory/user/'.$listing->hashed_id.'/claim'),'method'=>'POST', 'class'=>'ajax-form','id'=>'claim-form','data-page_action'=>"closeModal", "files"=>true]) !!}

                        {!! CoralsForm::textarea('brief_desctiption','Directory::attributes.claim.brief_desctiption',true, '', ['rows'=>5]) !!}
                        {!! CoralsForm::file('claim_file', 'Directory::attributes.claim.proof_of_business_registration',false) !!}

                        <button type="submit"
                                class="btn big-btn color-bg flat-btn">@lang('Directory::attributes.claim.send_claim')
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>@endsection

