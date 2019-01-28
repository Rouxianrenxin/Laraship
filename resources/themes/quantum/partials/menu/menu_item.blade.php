@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->user_can_access)
        <li class="nav-dropdown {{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a class="has-arrow"
               href="#" aria-expanded="false">
                {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!}
                <span>{{ $menu->name }}</span>
            </a>
            <ul aria-expanded="false" class="collapse nav-sub">
                @include('partials.menu.menu_item', ['menus'=>$menu->getChildren('active'), 'is_sub'=>true])
            </ul>
        </li>
    @elseif($menu->user_can_access)
        @if(isset($is_sub) && $is_sub)
            <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
                <a href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                    {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!} <span>{{ $menu->name }}</span>
                </a>
            </li>
        @else
            <li class="nav-dropdown {{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
                <a class="has-arrow" href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                    {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!} <span>{{ $menu->name }}</span>
                </a>
            </li>
        @endif
    @endif
@endforeach


