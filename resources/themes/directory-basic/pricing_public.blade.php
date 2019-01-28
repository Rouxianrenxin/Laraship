@extends('layouts.theme')


@section('editable_content')
    <div class="content">
        <section class="parallax-section" data-scrollax-parent="true" id="sec1">
            <div class="bg par-elem " data-bg="/assets/themes/directory-basic/images/bg/shapes-big.png"
                 data-scrollax="properties: { translateY: '30%' }"></div>
            <div class="overlay"></div>
            <div class="container">
                <div class="section-title center-align">
                    <h2><span>Our Tariff Plans</span></h2>
                    <div class="breadcrumbs fl-wrap"><a href="#">Home</a><span>Pricing Tables</span></div>
                    <span class="section-separator"></span>
                </div>
            </div>
            <div class="header-sec-link">
                <div class="container"><a href="#sec2"
                                          class="custom-scroll-link">@lang('corals-directory-basic::labels.dashboard.lets_start')</a>
                </div>
            </div>
        </section>
        <section  id="sec2">
            <div class="container">
                <div class="section-title">
                    <h2> Pricing Tables</h2>
                    <div class="section-subtitle">cost of our services</div>
                    <span class="section-separator"></span>
                    <p>Explore some of the best tips from around the city from our partners and friends.</p>
                </div>
                <div class="pricing-wrap fl-wrap">
                    <!-- price-item-->
                    <div class="price-item">
                        <div class="price-head op1">
                            <h3>Basic</h3>
                        </div>
                        <div class="price-content fl-wrap">
                            <div class="price-num fl-wrap">
                                <span class="curen">$</span>
                                <span class="price-num-item">49</span>
                                <div class="price-num-desc">Per month</div>
                            </div>
                            <div class="price-desc fl-wrap">
                                <ul>
                                    <li>One Listing</li>
                                    <li>90 Days Availability</li>
                                    <li>Non-Featured</li>
                                    <li>Limited Support</li>
                                </ul>
                                <a href="#" class="price-link">Choose Basic</a>
                            </div>
                        </div>
                    </div>
                    <!-- price-item end-->
                    <!-- price-item-->
                    <div class="price-item best-price">
                        <div class="price-head op2">
                            <h3>Extended</h3>
                        </div>
                        <div class="price-content fl-wrap">
                            <div class="price-num fl-wrap">
                                <span class="curen">$</span>
                                <span class="price-num-item">99</span>
                                <div class="price-num-desc">Per month</div>
                            </div>
                            <div class="price-desc fl-wrap">
                                <ul>
                                    <li>Ten Listings</li>
                                    <li>Lifetime Availability</li>
                                    <li>Featured In Search Results</li>
                                    <li>24/7 Support</li>
                                </ul>
                                <a href="#" class="price-link">Choose Extended</a>
                                <div class="recomm-price">
                                    <i class="fa fa-check"></i>
                                    <span class="clearfix"></span>
                                    Recommended
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- price-item end-->
                    <!-- price-item-->
                    <div class="price-item">
                        <div class="price-head">
                            <h3>Professional</h3>
                        </div>
                        <div class="price-content fl-wrap">
                            <div class="price-num fl-wrap">
                                <span class="curen">$</span>
                                <span class="price-num-item">149</span>
                                <div class="price-num-desc">Per month</div>
                            </div>
                            <div class="price-desc fl-wrap">
                                <ul>
                                    <li>Unlimited Listings</li>
                                    <li>Lifetime Availability</li>
                                    <li>Featured In Search Results</li>
                                    <li>24/7 Support</li>
                                </ul>
                                <a href="#" class="price-link">Choose Professional</a>
                            </div>
                        </div>
                    </div>
                    <!-- price-item end-->
                </div>
                <!-- about-wrap end  -->
                <span class="fw-separator"></span>
                <!-- features-box-container -->
                <div class="features-box-container fl-wrap row">
                    <!--features-box -->
                    <div class="features-box col-md-4">
                        <div class="time-line-icon">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <h3>24 Hours Support</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla.  </p>
                    </div>
                    <!-- features-box end  -->
                    <!--features-box -->
                    <div class="features-box col-md-4">
                        <div class="time-line-icon">
                            <i class="fa fa-cogs"></i>
                        </div>
                        <h3>Admin Panel</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla.  </p>
                    </div>
                    <!-- features-box end  -->
                    <!--features-box -->
                    <div class="features-box col-md-4">
                        <div class="time-line-icon">
                            <i class="fa fa-television"></i>
                        </div>
                        <h3>Mobile Friendly</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla.  </p>
                    </div>
                    <!-- features-box end  -->
                </div>
                <!-- features-box-container end  -->
            </div>
        </section>
        <!--  section end -->
        <!--  section  -->
        <section class="gradient-bg">
            <div class="cirle-bg">
                <div class="bg" data-bg="{{ Theme::url('/images/bg/circle.png') }}"></div>
            </div>
            <div class="container">
                <div class="join-wrap fl-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>Join our online community</h3>
                            <p>Grow your marketing and be happy with your online business</p>
                        </div>
                        <div class="col-md-4"><a href="#" class="join-wrap-btn modal-open">Sign Up <i class="fa fa-sign-in"></i></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!--  section end -->
        <div class="limit-box"></div>
    </div>

    @stop