<footer class="footer">
    <div class="space-50"></div>
    <div class="container">
        <div class="row vertical-align-child">
            <div class="col-md-4 margin-b-30">
                <div class="margin-b-20">
                    <a href="{{ url('/') }}">
                        <img src="{{ \Settings::get('site_logo') }}" alt="" style="width: 40%;">
                    </a>
                </div>
                <p>{!! \Settings::get('footer_text','') !!}</p>
            </div>
            <div class="col-md-4 margin-b-30">
                <ul class="list-unstyled">
                      @include('partials.menu.menu_item', ['menus' => Menus::getMenu('frontend_footer')])
                </ul>
            </div>
            <div class="col-md-4 margin-b-30 text-right">
                <ul class="list-inline social">
                    @foreach(\Settings::get('social_links',[]) as $key=>$link)
                        <li class="list-inline-item">
                            <a href="{{ $link }}" target="_blank"><i class="ion-social-{{ $key }}"></i></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="space-20"></div>
</footer>