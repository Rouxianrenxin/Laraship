<div class="fixed-bar fl-wrap">
    <div class="user-profile-menu-wrap fl-wrap">
        <!-- user-profile-menu-->
        <div class="user-profile-menu text-center">
            <h3><a href="{{ url('profile') }}">
                    <img src="{{ user()->picture_thumb }}" alt=""
                         style="width: 75px;height: auto;">
                </a></h3>
            <ul>
                <li><a href="#" class="user-profile-act"><i
                                class="fa fa-gears"></i>{{ user()->name }}</a></li>
                <li><a href="{{ url('profile') }}"><i
                                class="fa fa-user-o"></i>@lang('corals-directory-basic::labels.partial.my_profile')
                    </a></li>

                <li><a href="{{ url('notifications') }}" class="_dropdown-toggle" data-_toggle="dropdown">
                        <i class="fa fa-bell"></i>@lang('corals-directory-basic::labels.partial.notifications')
                        @if($unreadNotifications = user()->unreadNotifications()->count())
                            <span>{{ $unreadNotifications }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        <!-- user-profile-menu end-->
        <div class="user-profile-menu text-center">
            <ul class="dropdown">
                @include('partials.menu.dashboard_menu_item', ['menus'=> \Menus::getMenu('sidebar','active')])
            </ul>
        </div>
        <!-- user-profile-menu end-->
        <a href="{{ route('logout') }}" data-action="logout"
           class="log-out-btn"> @lang('corals-directory-basic::labels.partial.logout')</a>
    </div>
</div>