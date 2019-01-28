<section class="gray-section">
    <div class="container">
        <div class="section-title">
            <h2>@lang('corals-directory-basic::labels.template.home.popular_listings')</h2>
            <div class="section-subtitle">@lang('corals-directory-basic::labels.template.home.best_listings')</div>
            <span class="section-separator"></span>
        </div>
    </div>
    <!-- carousel -->
    <div class="list-carousel fl-wrap card-listing ">
        <!--listing-carousel-->
        <div class="listing-carousel  fl-wrap ">
            @foreach(\Corals\Modules\Directory\Facades\Directory::getListingsList(true) as $listing)
                <div class="slick-slide-item">
                    <!-- listing-item -->
                    <div class="listing-item">
                        <article class="geodir-category-listing fl-wrap">
                            <div class="geodir-category-img">
                                <img src="{{$listing->image}}" alt="">
                                <div class="overlay"></div>
                                @if(\Settings::get('directory_wishlist_enable',true))
                                    <div class="list-post-counter">@include('partials.components.wishlist_product',['wishlist'=> $listing->inWishList() ])

                                    </div>
                                @endif
                            </div>
                            <div class="geodir-category-content fl-wrap">
                                @foreach($listing->categories as $category)
                                    <a class="listing-geodir-category"
                                       href="{{url('listings?category='.$category->slug)}}">{{$category->name}}</a>
                                @endforeach
                                @if($listing->user)
                                    <div class="listing-avatar"><a
                                                href="{{ url('listings?user='.$listing->user->hashed_id)  }}"><img
                                                    src="{{$listing->user->picture_thumb}}"
                                                    alt=""></a>
                                        <span class="avatar-tooltip">@lang('corals-directory-basic::labels.template.home.added_by')
                                            <strong>{{$listing->user->full_name}}</strong></span>
                                    </div>
                                @endif
                                <h3><a href="{{$listing->getShowURL()}}">{{$listing->name}}</a></h3>
                                    <p>{{ str_limit($listing->caption ,70)}} </p>
                                <div class="geodir-category-options fl-wrap">
                                    @if(\Settings::get('directory_rating_enable',true))
                                        @include('partials.components.rating',['rating'=> $listing->averageRating(1)[0],'rating_count'=>$listing->countRating()[0] ])
                                    @endif
                                    <div class="geodir-category-location"><a href="#"><i class="fa fa-map-marker"
                                                                                         aria-hidden="true"></i>{{str_limit($listing->address,30,'..')??str_limit($listing->location->address,30,'..')}}
                                        </a></div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!-- listing-item end-->
                </div>
            @endforeach
        </div>
        <!--listing-carousel end-->
        <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
        <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
    </div>
    <!--  carousel end-->
</section>