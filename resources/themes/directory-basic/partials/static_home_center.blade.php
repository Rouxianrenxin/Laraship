<section class="parallax-section" data-scrollax-parent="true">
    <div class="bg" data-bg="{{ Theme::url('/images/bg/signup-banner.png') }}"
         data-scrollax="properties: { translateY: '100px' }"></div>
    <div class="overlay co lor-overlay"></div>
    <!--container-->
    <div class="container">
        <div class="intro-item fl-wrap">
            <h2>@lang('corals-directory-basic::labels.template.home.visit_the_best_places_in_your_city')</h2>
            <h3>@lang('corals-directory-basic::labels.template.home.find_great_places_hotels_restourants_shops')</h3>
            @if(user() && user()->hasPermissionTo('Directory::listing.create'))
                <a class="trs-btn"
                   href="{{url('directory/user/listings/create')}}">@lang('corals-directory-basic::labels.template.home.add_listing')
                    + </a>
            @endif
        </div>
    </div>
</section>