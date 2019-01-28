@foreach($menus as $menu)
  @if($menu->hasChildren('active') && $menu->user_can_access)
      <li class="nav-item has-menu {{ \Request::is($menu->active_menu_url)?'active':'' }}">
          <a class="nav-link" href="#">
              @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
              <i class="ion-chevron-down"></i>
          </a>
          <div class="sub-menu">
              <ul class="menu-list">
                  @include('partials.menu.menu_item', ['menus' => $menu->getChildren('active'), 'sub' => true])
              </ul>
          </div>
      </li>
  @elseif($menu->user_can_access)
      <li class="{{ !$sub?'nav-item ':'' }} {{ \Request::is($menu->active_menu_url)?'active':'' }}">
          <a class="{{ !$sub?'nav-link':'' }}" href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
              @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
          </a>
      </li>
  @endif
@endforeach