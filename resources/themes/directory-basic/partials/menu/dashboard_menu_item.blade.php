@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->user_can_access)
        <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active menu-open':'' }}">
            <a href="#" style="padding-bottom: 10px">
                @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif <h2 style="display: inline-block">{{ $menu->name }}</h2>
            </a>
            <ul class="sub-menu">
                @include('partials.menu.menu_item', ['menus'=>$menu->getChildren('active')])
            </ul>
        </li>
    @elseif($menu->user_can_access)
        <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!} <h2 style="display: inline-block">{{ $menu->name }}</h2>
            </a>
        </li>
    @endif
@endforeach
