<div class="sidebar-box">
    <div class="user">
        <figure>
            <a href="{{ url('profile') }}">
                <img src="{{ user()->picture_thumb }}" alt="" style="width: 75px;height: auto;">
            </a>
        </figure>
        <div class="usercontent">
            <h3>{{ user()->name }}</h3>
            <h4>{{ user()->job_title }}</h4>
            <a class="btn btn-info btn-sm"
               href="{{ url('profile') }}">@lang('corals-classified-master::auth.profile')</a>
        </div>
    </div>
    <nav class="navdashboard">
        <ul>
            <li>
                <a href="{{ url('classified/user/dashboard') }}"
                   class="{{ \Request::is('classified/user/dashboard')?'active':'' }}">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            @include('partials.menu.dashboard_menu_item', ['menus'=> \Menus::getMenu('sidebar','active')])
        </ul>
    </nav>
</div>