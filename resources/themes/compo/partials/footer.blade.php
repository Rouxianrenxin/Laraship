<footer class="footer">         <!-- Footer -->
    <div class="footer-pri">            <!-- Primary Footer -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 footer-widget">            <!-- Footer Widget - Quick Links -->
                    <h5 class="heading text-white">Quick <span class="text-primary">Links</span></h5>
                    <ul class="quick-links">
                        @include('partials.menu.menu_item', ['menus' => Menus::getMenu('frontend_footer','active'), 'sub' => false])

                        @if(count(\Settings::get('supported_languages', [])) > 1)
                            {!! \Language::flags('list-unstyled') !!}
                        @endif
                    </ul>
                </div>
                <div class="col-lg-3 footer-widget">            <!-- Footer Widget - Contact Info -->
                    <h5 class="heading text-white">Contact <span class="text-primary">Us</span></h5>
                    <address>
                        <p class="text-primary"></p>
                        <span>first Floor,<br/> Abraj Al-Wataniya Building,<br/> Palestine</span>
                    </address>
                    <p class="text-primary mb-0">
                        <i class="fa fa-phone fa-fw"></i> {{ \Settings::get('contact_mobile','+970599593301') }}
                    </p>
                    <p class="text-primary">
                        <i class="fa fa-envelope fa-fw"></i> {{ \Settings::get('contact_form_email','support@corals.io') }}
                    </p>
                </div>
                <div class="col-lg-6 footer-widget text-center">            <!-- Footer Widget - Policies -->
                    <h5 class="heading text-white">Start Your business <span class="text-primary">With</span></h5>
                    <div class="" style="display: table;height: 100%;width: 100%;">
                        <a class="footer-logo" style="display: table-cell;vertical-align: top;"
                           href="{{ url('/') }}">
                            <img src="{{ \Settings::get('site_logo_white') }}"
                                 alt="{{ \Settings::get('site_name', 'Corals') }}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-sec">            <!-- Secondary Footer -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 text-center">
                    <span class="copyright">{!! \Settings::get('footer_text','') !!}</span>
                    <!-- Copyright Text -->
                </div>
                <div class="col-lg-6">
                    <ul class="social justify-content-center">          <!-- Social Media Links -->
                        @foreach(\Settings::get('social_links',[]) as $key=>$link)
                            <li><a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $key }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>