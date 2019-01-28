<footer class="main-footer dark-footer  ">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="footer-widget fl-wrap">
                    <h3>@lang('corals-directory-basic::labels.footer.about_us')</h3>
                    <div class="footer-contacts-widget fl-wrap">
                        <p>@lang('corals-directory-basic::labels.footer.about_us_description')</p>
                        <ul class="footer-contacts fl-wrap">
                            <li><span><i class="fa fa-envelope-o"></i>@lang('corals-directory-basic::labels.footer.mail')</span><a href="mailto:{{ \Settings::get('contact_form_email','support@corals.io') }}"
                                                                                       target="_blank">{{ \Settings::get('contact_form_email','support@corals.io') }}</a>
                            </li>
                            <li><span><i class="fa fa-phone"></i>@lang('corals-directory-basic::labels.footer.phone')</span><a
                                        href="#"> {{ \Settings::get('contact_mobile','+970599593301') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-widget fl-wrap">
                    <h3>@lang('corals-directory-basic::labels.footer.our_last_news')</h3>
                    <div class="widget-posts fl-wrap">
                        <ul>
                            @foreach(\CMS::getLatestNews(3) as $newsItem)
                                <li class="clearfix">
                                    <a href="{{ url($newsItem->slug) }}" class="widget-posts-img"></a>
                                    <div class="widget-posts-descr">
                                        <a href="{{ url($newsItem->slug) }}" title="">{{ $newsItem->title }}</a>
                                        <span class="widget-posts-date"> {{ format_date($newsItem->published_at) }} </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-widget fl-wrap">
                    <h3>@lang('corals-directory-basic::labels.footer.our_twitter')</h3>
                    <div id="footer-twiit"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-widget fl-wrap">
                    <h3>@lang('corals-directory-basic::labels.footer.subscribe')</h3>
                    <div class="subscribe-widget fl-wrap">
                        <p>@lang('corals-directory-basic::labels.footer.subscribe_description')</p>

                        {!! Form::open( ['url' => url('utilities/newsletter/subscribe'),'method'=>'POST', 'class'=>'ajax-form','id'=>'subscribe']) !!}

                        <div class="form-group">
                            <input class="enteremail" name="email" id="subscribe-email"
                                   placeholder="@lang('corals-directory-basic::labels.template.home.your_email')"
                                   spellcheck="false" type="text">
                            <input type="hidden" name="list_id">

                        </div>
                        <button type="submit" id="subscribe-button" class="subscribe-button"><i
                                    class="fa fa-rss"></i> @lang('corals-directory-basic::labels.template.home.subscribe')
                        </button>
                        <label for="subscribe-email" class="subscribe-message"></label>
                        {!! Form::close() !!}

                    </div>
                    <div class="footer-widget fl-wrap">
                        <div class="footer-menu fl-wrap">
                            <ul>
                                @foreach(Menus::getMenu('frontend_footer','active') as $menu)
                                    <li><a href="{{url($menu->url)}}">@if($menu->icon)<i
                                                    class="{{ $menu->icon }} fa-fw"></i>@endif{{$menu->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer fl-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="about-widget">
                        <a class="footer-logo" style="display: table-cell;vertical-align: middle;"
                           href="{{ url('/') }}">
                            <img src="{{ \Settings::get('site_logo') }}"
                                 alt="{{ \Settings::get('site_name', 'Corals') }}">
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="footer-copyright color-white">
                        {!! \Settings::get('footer_text','') !!}
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="footer-social">
                        <ul class="social justify-content-center">          <!-- Social Media Links -->
                            @foreach(\Settings::get('social_links',[]) as $key=>$link)
                                <li><a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $key }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a class="to-top"><i class="fa fa-angle-up"></i></a>
