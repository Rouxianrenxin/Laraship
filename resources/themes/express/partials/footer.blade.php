<div class="footer footer--light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ \Settings::get('site_logo') }}" class="mr-2 img-fluid" style="max-width: 200px;"/>
                </a>
            </div>
            <div class="col-md-3 text-center">
                <ul class="list-inline">
                    @foreach(Menus::getMenu('frontend_footer','active') as $menu)
                        <li class="list-inline-item">
                            <a href="{{ url($menu->url) }}">
                                @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <ul class="list-inline">
                    @foreach(\Settings::get('social_links',[]) as $key=>$link)
                        <li class="list-inline-item">
                            <a href="{{ $link }}" target="_blank"><i class="fa fa-2x fa-fw fa-{{ $key }}"></i></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="credits">
            <p>{!! \Settings::get('footer_text') !!}</p>
        </div>
    </div>
</div>