@extends('layouts.theme')

@section('hero_area')
    <!-- Hero Area Start -->

    <div id="hero-area">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                    <div class="contents">
                        {!! $item->rendered !!}
                        <div class="search-bar">
                            @include('partials.hero_area_search',compact('categories','locations'))
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->
    @php \Actions::do_action('pre_content',$item,true) @endphp

@endsection
<!-- Hero Area End -->
@section('editable_content')
    @include('partials.trending_categories')

    @include('partials.latest_products')

    @include('partials.featured_products')

    <section class="services section-padding">
        <div class="container">
            {!!   \Shortcode::compile( 'block','home-features' ) ; !!}
        </div>
    </section>

    @include('partials.counter_area');
    <!--
        <section id="pricing-table" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mainHeading">
                            <h2 class="section-title">Select A Package</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table">
                            <div class="icon">
                                <i class="lni-gift"></i>
                            </div>
                            <div class="title">
                                <h3>SILVER</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>29<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>No</strong> Featured ads availability</li>
                                <li><strong>For 30</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table" id="active-tb">
                            <div class="icon">
                                <i class="lni-leaf"></i>
                            </div>
                            <div class="title">
                                <h3>STANDARD</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>89<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>6</strong> Featured ads availability</li>
                                <li><strong>For 30</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table">
                            <div class="icon">
                                <i class="lni-layers"></i>
                            </div>
                            <div class="title">
                                <h3>PLANINIUM</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>99<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>20</strong> Featured ads availability</li>
                                <li><strong>For 25</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    -->

    <!-- Subscribe Section Start -->
    <section class="subscribes section-padding">
        <div class="container">
            <div class="row wrapper-sub">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <p>@lang('corals-classified-master::labels.template.home.join')</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    {!! Form::open( ['url' => url('utilities/newsletter/subscribe'),'method'=>'POST', 'class'=>'ajax-form','id'=>'subscribeForm']) !!}

                    <div class="subscribe">
                        <div class="form-group">
                            <label name="list_id"></label>
                            <input class="form-control" name="email"
                                   placeholder="@lang('corals-classified-master::labels.template.home.your_email')"
                                   type="text">
                        </div>

                        <button class="btn btn-common"
                                type="submit">@lang('corals-classified-master::labels.template.home.subscribe')</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Subscribe Section End -->
@stop