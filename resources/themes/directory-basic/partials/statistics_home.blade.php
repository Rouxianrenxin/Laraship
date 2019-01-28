@php $userCount = \Users::getActiveUsersCount() @endphp
<section class="color-bg">
    <div class="shapes-bg-big"></div>
    <div class="container">
        <div class=" single-facts fl-wrap">
            <!-- inline-facts -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0"
                                 data-num="{{ $userCount }}">{{ $userCount }}</div>
                        </div>
                    </div>
                    <h6>@lang('corals-directory-basic::labels.template.home.members')</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0"
                                 data-num="{{\Corals\Modules\Utility\Facades\Address\Address::getLocationsCount('Directory','active')}}">
                                12168
                            </div>
                        </div>
                    </div>
                    <h6>@lang('corals-directory-basic::labels.template.home.locations')</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0"
                                 data-num="{{\Corals\Modules\Directory\Facades\Directory::getListingsCount('active')}}"></div>
                        </div>
                    </div>
                    <h6>@lang('corals-directory-basic::labels.template.home.listings')</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num" data-content="0"
                                 data-num="{{\Corals\Modules\Directory\Facades\Directory::getListingsVisitorsCount('active')}}">
                                732
                            </div>
                        </div>
                    </div>
                    <h6>@lang('corals-directory-basic::labels.template.home.listings_visitors')</h6>
                </div>
            </div>
            <!-- inline-facts end -->
        </div>
    </div>
</section>