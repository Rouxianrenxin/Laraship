@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->isRoot() && $menu->user_can_access)
        <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }} {{ $menu->isRoot()?'':'has-children' }}">
            <a href="{{ url($menu->url) }}" class="act-link">
                @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endif {{ $menu->name }}
            </a>
            <!--second level -->
            <ul class="@if($menu->hasChildren())has-submenu @endif">
                @include('partials.menu.menu_item', ['menus' => $menu->getChildren('active')])
            </ul>
            <!--second level end-->
        </li>
    @elseif($menu->user_can_access)
        <li class="@if($menu->hasChildren())has-submenu @endif {{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a class="{{ \Request::is(explode(',',$menu->active_menu_url))?'act-link':'' }}"
               href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endif
                {{ $menu->name }}
            </a>
            @if($menu->hasChildren())
                <ul class="sub-menu">
                    @include('partials.menu.menu_item', ['menus' => $menu->getChildren('active')])
                </ul>
            @endif
        </li>
    @endif

@endforeach