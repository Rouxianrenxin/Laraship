@php
    $wishlistManager = new Corals\Modules\Utility\Classes\Wishlist\WishlistManager(new \Corals\Modules\Directory\Models\Listing);
    $wishlistCount = $wishlistManager->getUserWishlist(true);
@endphp

<div class="profile-edit-container">
    <div class="profile-edit-header fl-wrap" style="margin-top:30px">
        <h4>@lang('corals-directory-basic::labels.dashboard.hello') ,
            <span>{{user()->name}}</span></h4>
    </div>
    <!-- statistic-container-->
    <div class="statistic-container fl-wrap">
        <!-- statistic-item-wrap-->
        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa-map-marker"></i>
                <div class="statistic-item-numder">{{\Corals\Modules\Directory\Facades\Directory::getListingsCount('active',user()->id)}}</div>
                <h5>@lang('corals-directory-basic::labels.dashboard.active_listings')</h5>
            </div>
        </div>
        <!-- statistic-item-wrap end-->
        <!-- statistic-item-wrap-->
        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa fa-eye"></i>
                <div class="statistic-item-numder">{{\Corals\Modules\Directory\Facades\Directory::getListingsVisitorsCount('active',user()->id)}}</div>
                <h5>@lang('corals-directory-basic::labels.dashboard.listing_views')</h5>
            </div>
        </div>
        <!-- statistic-item-wrap end-->
        <!-- statistic-item-wrap-->
        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa-comments-o"></i>
                <div class="statistic-item-numder">{{\Corals\Modules\Directory\Facades\Directory::getUserListingReviewsCount(user()->id)}}</div>
                <h5>@lang('corals-directory-basic::labels.dashboard.total_reviews')</h5>
            </div>
        </div>
        <!-- statistic-item-wrap end-->
        <!-- statistic-item-wrap-->
        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa-heart-o"></i>
                <div class="statistic-item-numder">{{$wishlistCount}}</div>
                <h5>@lang('corals-directory-basic::labels.dashboard.times_bookmarked')</h5>
            </div>
        </div>
        <!-- statistic-item-wrap end-->
    </div>
</div>