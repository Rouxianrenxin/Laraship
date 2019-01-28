<div class="listing-item">
    <article class="geodir-category-listing fl-wrap">
        <div class="geodir-category-img">
            <img src="{{$listing->image}}" alt="Listing">
            <div class="overlay"></div>
            @if(\Settings::get('directory_wishlist_enable',true))
                <div class="list-post-counter">
                    <span>{{$listing->wishlistsCount()}}</span>@include('partials.components.wishlist_product',['wishlist'=> $listing->inWishList() ])

                </div>
            @endif
        </div>
        <div class="geodir-category-content fl-wrap">
            <div class="listing-geodir-category">
                @foreach($listing->activeCategories as $category)
                    <a href="{{ url('listings?category='.$category->slug) }}">{{ $category->name }}</a> @if(!$loop->last)
                        &nbsp; |
                        &nbsp;
                    @endif
                @endforeach

            </div>
            @if($listing->user)
                <div class="listing-avatar">
                    <a
                            href="{{ url('listings?user='.$listing->user->hashed_id) }}"><img
                                src="{{$listing->user->picture_thumb}}"
                                alt=""></a>
                    <span class="avatar-tooltip">@lang('corals-directory-basic::labels.template.product_single.added_by')
                        <strong>{{$listing->user->full_name}}</strong></span>
                </div>
            @endif
            <h3><a href="{{$listing->getShowURL()}}">{{$listing->name}}</a></h3>
            <p>{!! str_limit($listing->description)  !!}</p>
            <div class="geodir-category-options fl-wrap">
                @if(\Settings::get('ecommerce_rating_enable',true) === 'true')
                    @include('partials.components.rating',['rating'=> $listing->averageRating(1)[0],'rating_count'=>null])
                @endif
                <div class="geodir-category-location"><a href="#{{  ++$loop->index  }}"
                                                         class="map-item scroll-top-map"><i
                                class="fa fa-map-marker"
                                aria-hidden="true"></i>{{$listing->location->name}}</a>
                </div>
            </div>
        </div>
    </article>
</div>