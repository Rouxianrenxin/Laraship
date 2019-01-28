<footer class="site-footer" style="background-image: url('/assets/themes/ecommerce-ultimate/img/footer-bg.png');">
    <div class="container">

        <hr class="hr-light mt-2 margin-bottom-2x hidden-md-down">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <!-- Contact Info-->
                <section class="widget widget-light-skin">
                    <h3 class="widget-title">@lang('corals-ecommerce-ultimate::labels.partial.get_touch_us')</h3>
                    <p class="text-white">@lang('corals-ecommerce-ultimate::labels.partial.mobile')  {{ \Settings::get('contact_mobile','+970599593301') }}</p>
                    <ul class="list-unstyled text-sm text-white">
                        <li>
                            <span class="opacity-50">@lang('corals-ecommerce-ultimate::labels.partial.monday_friday') </span>9.00
                            am - 8.00 pm
                        </li>
                        <li><span class="opacity-50">@lang('corals-ecommerce-ultimate::labels.partial.saturday') </span>10.00
                            am -
                            6.00 pm
                        </li>
                    </ul>
                    <p><a class="navi-link-light"
                          href="#">{{ \Settings::get('contact_form_email','support@corals.io') }}</a>
                    </p>
                    @foreach(\Settings::get('social_links',[]) as $key=>$link)
                        <a class="social-button shape-circle sb-{{ $key }} sb-light-skin" href="{{ $link }}"
                           target="_blank"><i class="socicon-{{ $key }}"></i>
                        </a>
                    @endforeach
                </section>
            </div>
            <div class="col-lg-3">
                <!-- Subscription-->
                <section class="widget widget-links widget-light-skin">
                    <h3 class="widget-title">
                        @lang('corals-ecommerce-ultimate::labels.partial.footer_menu')
                    </h3>
                    <ul>
                        @foreach(Menus::getMenu('frontend_footer','active') as $menu)
                            <li>
                                <a href="{{ url($menu->url) }}">@if($menu->icon)<i
                                            class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Mobile App Buttons-->
                <section class="widget widget-light-skin">
                    <h3 class="widget-title">@lang('corals-ecommerce-ultimate::labels.partial.mobile_app')</h3><a
                            class="market-button apple-button mb-light-skin" href="#"><span
                                class="mb-subtitle">@lang('corals-ecommerce-ultimate::labels.partial.download')</span><span
                                class="mb-title">@lang('corals-ecommerce-ultimate::labels.partial.app_store')</span></a><a
                            class="market-button google-button mb-light-skin" href="#"><span
                                class="mb-subtitle">@lang('corals-ecommerce-ultimate::labels.partial.download')</span><span
                                class="mb-title">@lang('corals-ecommerce-ultimate::labels.partial.google_play')</span></a><a
                            class="market-button windows-button mb-light-skin" href="#"><span
                                class="mb-subtitle">@lang('corals-ecommerce-ultimate::labels.partial.download')</span><span
                                class="mb-title">@lang('corals-ecommerce-ultimate::labels.partial.windows_store')</span></a>
                </section>
            </div>
            <div class="col-lg-3 col-md-6">
                <div style="display: table;height: 100%;">
                    <a class="footer-logo" style="display: table-cell;vertical-align: middle;" href="{{ url('/') }}">
                        <img src="{{ \Settings::get('site_logo') }}" alt="{{ \Settings::get('site_name', 'Corals') }}">
                    </a>
                </div>
            </div>
        </div>
        <hr class="hr-light mt-2 margin-bottom-2x">

        <div class="row">
            <div class="col-md-7 padding-bottom-1x">
                <!-- Payment Methods-->
                <div class="margin-bottom-1x" style="max-width: 615px;"><img
                            src="/assets/themes/ecommerce-ultimate/img/credit-cards-footer.png"
                            alt="Payment Methods">
                </div>
            </div>
            <div class="col-md-5 padding-bottom-1x">
            </div>
        </div>
        <!-- Copyright-->
        <p class="footer-copyright">
            {!! \Settings::get('footer_text','') !!}
        </p>
    </div>
</footer>
<!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-chevron-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>