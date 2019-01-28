<!-- Counter Area Start-->
@php
    $productsCount = \Classified::getActiveProductsCount();
    $locationCount = \Classified::getActiveLocationsCount();
    $userCount = \Users::getActiveUsersCount();
    $featuredProductsCount =\Classified::getActiveProductsCount(true);
@endphp
<section class="counter-section section-padding">
    <div class="container">
        <div class="row">
            <!-- Counter Item -->
            <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                <div class="counter">
                    <div class="icon"><i class="lni-layers"></i></div>
                    <h2 class="counterUp">{{$productsCount}}</h2>
                    <p>@lang('corals-classified-master::labels.template.home.regular_ads')</p>
                </div>
            </div>
            <!-- Counter Item -->
            <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                <div class="counter">
                    <div class="icon"><i class="lni-map"></i></div>
                    <h2 class="counterUp">{{$locationCount}}</h2>
                    <p>@lang('corals-classified-master::labels.template.home.locations')</p>
                </div>
            </div>
            <!-- Counter Item -->
            <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                <div class="counter">
                    <div class="icon"><i class="lni-user"></i></div>
                    <h2 class="counterUp">{{$userCount}}</h2>
                    <p>@lang('corals-classified-master::labels.template.home.members')</p>
                </div>
            </div>
            <!-- Counter Item -->
            <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                <div class="counter">
                    <div class="icon"><i class="lni-briefcase"></i></div>
                    <h2 class="counterUp">{{$featuredProductsCount}}</h2>
                    <p>@lang('corals-classified-master::labels.template.home.premuim_ads')</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Counter Area End-->