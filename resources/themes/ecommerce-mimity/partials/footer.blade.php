<div class="navbar navbar-expand navbar-light navbar-footer" id="footer">
    <a class="navbar-brand" style="display: table-cell;vertical-align: middle;" href="{{ url('/') }}">
        <img src="{{ \Settings::get('site_logo') }}" alt="{{ \Settings::get('site_name', 'Corals') }}">
    </a>
    <ul class="navbar-nav">
        @foreach(Menus::getMenu('frontend_footer','active') as $menu)
            <li class="nav-item">
                <a class="nav-link" href="{{ url($menu->url) }}">@if($menu->icon)<i
                            class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}</a>
            </li>
        @endforeach
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#">{!! \Settings::get('footer_text','') !!}</a>
        </li>
    </ul>
</div>
