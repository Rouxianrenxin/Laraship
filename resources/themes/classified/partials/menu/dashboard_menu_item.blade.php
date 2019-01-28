@foreach($menus as $menu)
    @if($menu->hasChildren('active') && $menu->user_can_access)
        <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a href="#" class="" data-toggle="collapse" data-target="#collapse_{{$menu->id}}_x"
               aria-expanded="false"
               aria-controls="collapse_{{$menu->id}}" }}>
                <span class="float-left">
                    {!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!} {{ $menu->name }}
                </span>
                <span class="float-right">
                    <i class="fa fa-angle-left toggle-icon"></i>
                </span>
            </a>
            <ul class="sub-menu">
                <div id="collapse_{{$menu->id}}_x" class="panel-collapse collapse"
                     role="tabpanel">
                    @include('partials.menu.dashboard_menu_item', array('menus'=>$menu->getChildren('active')))
                </div>
            </ul>
        </li>
    @elseif($menu->user_can_access)
        <li class="{{ \Request::is(explode(',',$menu->active_menu_url))?'active':'' }}">
            <a href="{{ url($menu->url) }}" target="{{ $menu->target??'_self' }}">
                <span>{!! $menu->icon?'<i class="'. $menu->icon .' fa-fw"></i> ':'' !!} {{ $menu->name }}</span>
            </a>
        </li>
    @endif
@endforeach
