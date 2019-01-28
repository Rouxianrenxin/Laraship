@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->isRoot() && $menu->user_can_access)
        <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }} {{ $menu->isRoot()?'':'has-children' }}">
          <span>
          <a href="{{ url($menu->url) }}">
              <span>@if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}</span>
          </a>
             <span class="sub-menu-toggle"></span>
          </span>
            <ul class="slideable-submenu">
                @include('partials.menu.menu_item', ['menus' => $menu->getChildren('active')])
            </ul>
        </li>
    @elseif($menu->user_can_access)
        <li class="has-children {{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
          <span>
             <a href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                 <span>@if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}</span>
                  <span class="sub-menu-toggle"></span>
             </a>
         </span>
            <ul class="slideable-submenu">
                @include('partials.menu.menu_item', ['menus' => $menu->getChildren('active')])
            </ul>
        </li>
    @endif
@endforeach