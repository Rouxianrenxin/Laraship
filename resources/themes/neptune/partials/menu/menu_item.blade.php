@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->user_can_access)
        <li class="nav-item dropdown {{ \Request::is($menu->active_menu_url)?'active':'' }}">
            <a class="nav-link dropdown-toggle" href="#" data-hover="dropdown" data-delay="0"
               data-close-others="false">
                @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
                <i class="fa fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @include('partials.menu.menu_item', ['menus' => $menu->getChildren('active') ,'child'=>true])
            </div>
        </li>
    @elseif($menu->user_can_access)
        @if(isset($child) && $child)
            <a class="dropdown-item {{ \Request::is($menu->active_menu_url)?'active':'' }}" href="{{ url($menu->url) }}"
               target="{{ $menu->target??'_self' }}">
                @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
            </a>
        @else
            <li class="nav-item {{ \Request::is($menu->active_menu_url)?'active':'' }}">
                <a class="nav-link" href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                    @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
                </a>
            </li>
        @endif
    @endif
@endforeach