@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->user_can_access)
        <li>
            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               href="#">
                {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}
            </a>

            <ul class="dropdown">
                @foreach($menu->getChildren('active') as $menu)
                    @if(!$menu->user_can_access)
                        @continue
                    @endif
                    <li>
                        <a href="{{ url($menu->url) }}">
                            {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @elseif($menu->user_can_access)
        <li>
            <a class="nav-link" href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}{{ $menu->name }}
            </a>
        </li>
    @endif
@endforeach