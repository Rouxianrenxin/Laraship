<!-- Footer Section Start -->
<footer>
    <!-- Footer Area Start -->
    <section class="footer-Content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="footer-logo">
                            <img src="{{ \Settings::get('site_logo_white') }}" alt="">
                        </h3>
                        <div class="textwidget">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lobortis tincidunt est,
                                et euismod purus suscipit quis. Etiam euismod ornare elementum. Sed ex est, consectetur
                                eget facilisis sed, auctor ut purus.</p>
                        </div>
                    </div>
                    <div class="widget">

                        <div id="language-currency-selector">

                            <ul class="list-unstyled currencies" style="display: inline-block;">
                                @php \Actions::do_action('post_display_frontend_menu') @endphp
                            </ul>
                            @if(count(\Settings::get('supported_languages', [])) > 1)
                                <li class="dropdown locale" style="list-style-type: none;display: inline-block">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        {!! \Language::flag() !!} {!! \Language::getName() !!}
                                    </a>
                                    {!! \Language::flags('dropdown-menu') !!}

                                </li>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title">@lang('corals-classified-master::labels.partial.latest_products')</h3>
                        <ul class="media-content-list">
                            @foreach(\Classified::getProductsList(true,2) as $product)
                                <li>
                                    <div class="media-left">
                                        <img class="img-fluid" src="{{$product->image}}" alt="">
                                        <div class="overlay">
                                            <span class="price">{{$product->present('price')}}</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a
                                                    href="{{url('products/'.$product->slug)}}">{{$product->name}}</a>
                                        </h4>
                                        <span class="date">{{$product->created_at->diffForHumans()}}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">
                        <h3 class="block-title">@lang('corals-classified-master::labels.partial.help_support')</h3>
                        <ul class="menu">
                            @foreach(Menus::getMenu('frontend_footer','active') as $menu)
                                <li>
                                    <a href="{{ url($menu->url) }}">
                                        {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                    <div class="widget">

                        <h3 class="block-title">@lang('corals-classified-master::labels.partial.subscribe_us')</h3>
                        <p class="text-sub">@lang('corals-classified-master::labels.partial.subscribe_footer_text')</p>
                        {!! Form::open( ['url' => url('utilities/newsletter/subscribe'),'method'=>'POST', 'class'=>'ajax-form','id'=>'subscribe-form']) !!}
                        <div class="form-group">
                            <span name="list_id"></span>
                            <input class="form-control" name="email"
                                   placeholder="@lang('corals-classified-master::labels.template.home.your_email')"
                                   type="text">
                            <button type="submit" name="subscribe" id="subscribes" class="btn btn-common sub-btn"><i
                                        class="lni-check-box"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        {!! Form::close() !!}
                        <ul class="footer-social">
                            @foreach(\Settings::get('social_links',[]) as $key=>$link)
                                <li>
                                    <a class="{{ $key }}" href="{{ $link }}"
                                       target="_blank"><i class="fa fa-{{ $key }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer area End -->

    <!-- Copyright Start  -->
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-info float-left">
                        <p>{!! \Settings::get('footer_text','') !!}</p>
                    </div>
                    <div class="float-right">
                        <ul class="bottom-card">
                            <li>
                                <a href="#"><img src="{{ Theme::url('img/footer/card1.jpg') }}" alt="card"></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ Theme::url('img/footer/card2.jpg') }}" alt="card"></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ Theme::url('img/footer/card3.jpg') }}" alt="card"></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ Theme::url('img/footer/card4.jpg') }}" alt="card"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

</footer>
<!-- Footer Section End -->