@foreach($menus as $menu)
    @if($menu->hasChildren('active')  && $menu->user_can_access)
        <li class="nav-item dropdown {{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               href="#">
                {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}
            </a>

            <div class="dropdown-menu">
                @foreach($menu->getChildren('active') as $menu)
                    @if(!$menu->user_can_access)
                        @continue
                    @endif

                    <a class="dropdown-item" href="{{ url($menu->url) }}">
                        {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}
                    </a>
                @endforeach
            </div>
        </li>
    @elseif($menu->user_can_access)
        <li class="nav-item {{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a class="nav-link" href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}
            </a>
        </li>
    @endif
@endforeach