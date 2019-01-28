<nav class="top-toolbar navbar navbar-mobile navbar-tablet">
    <ul class="navbar-nav nav-left">
        <li class="nav-item">
            <a href="javascript:void(0)" data-toggle-state="aside-left-open">
                <i class="fa fa-align-left"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav nav-center site-logo">
        <li>
            <a href="{{ url('/') }}">
                <div class="logo_mobile">
                    <img src="{{ \Settings::get('site_logo') }}" alt="{{ \Settings::get('site_name') }}"
                         class="dark-logo"/>
                </div>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav nav-right">
        <li class="nav-item">
            <a href="javascript:void(0)" data-toggle-state="mobile-topbar-toggle">
                <i class="fa fa-ellipsis-v"></i>
            </a>
        </li>
    </ul>
</nav>
<nav class="top-toolbar navbar navbar-desktop flex-nowrap">
    <ul class="navbar-nav nav-right">
        <div class="navbar-nav modules-custom-nav">
            @php Actions::do_action('show_navbar') @endphp
        </div>
        @if(count(\Settings::get('supported_languages', [])) > 1)
            <li class="nav-item dropdown">
                <a class="has-arrow" href="#" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" style="padding: 11px 0px;">
                    {!! \Language::flag() !!}
                </a>
                <div class="dropdown-menu dropdown-menu-right animated bounceInDown p-3">
                    {!! \Language::flags('list-unstyled','mb-1') !!}
                </div>
            </li>
        @endif
        @if (schemaHasTable('announcements'))
            <li class="nav-item dropdown">
                <a class="has-arrow" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bullhorn"></i>
                    @if($unreadAnnouncements = \Announcement::unreadAnnouncements())
                        {{ $unreadAnnouncements }}
                        <div class="notify"><span class="heartbit"></span>
                            <span class="point"></span></div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
            @if($unreadAnnouncements)
                <li>
                    <div class="drop-title">@lang('Announcement::labels.unread_count_message',['count'=>$unreadAnnouncements])</div>
                </li>
                <li>
                    <div class="message-center">
                        @foreach(\Announcement::unreadAnnouncements(user(), false, 5) as $announcement)
                            <a href="{{ $announcement->getShowURL() }}"
                               class="show_announcement"
                               data-ann_hashed_id="{{ $announcement->hashed_id }}"
                               data-title="{{ $announcement->title }}">
                                @if($announcement->image)
                                    <div class="user-img">
                                        <img src="{{ $announcement->image }}" alt="ann"
                                             class="img-fluid">
                                    </div>
                                @else
                                    <div class="btn btn-info btn-circle">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                @endif
                                <div class="mail-contnet">
                                    <span class="mail-desc">{{ $announcement->title }}</span>
                                    <span class="time">{{ $announcement->starts_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </li>
            @endif
            <a class="dropdown-item" href="{{ url('announcements') }}">
                <strong>@lang('Announcement::labels.see_all')</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        @endif
        @if (schemaHasTable('notifications'))
            <li class="nav-item">
                <a href="{{ url('notifications') }}" class="has-arrow" role="button" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    @if($unreadNotifications = user()->unreadNotifications()->count())

                        <div class="notify">
                            <span class="heartbit">{{ $unreadNotifications }}</span>
                            <span class="point"></span></div>
                    @endif
                </a>
            </li>
        @endif
        @if (user()->can('Settings::module.manage') && !config('settings.models.module.disable_update'))
            <li class="nav-item">
                <a href="{{ url('modules') }}" class="has-arrow"
                   aria-expanded="false">
                    <i class="fa fa-fw fa-refresh"></i>
                    @if($updatesAvailable = \Modules::hasUpdates())
                        {{ $updatesAvailable  }}
                        <div class="notify"><span class="heartbit"></span> <span
                                    class="point"></span></div>
                    @endif
                </a>
            </li>
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link nav-pill user-avatar p-r-10" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                <img src="{{ user()->picture_thumb }}" class="w-35 rounded-circle" alt="{{ user()->name }}">
                <span class="hidden-md-down">{{ user()->name }} <i class="fa fa-angle-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
                <div class="dropdown-header pb-3">
                    <div class="media d-user">
                        <img class="align-self-center mr-3 w-40 rounded-circle"
                             src="{{ user()->picture_thumb }}" alt="{{ user()->name }}">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">{{ user()->name }}</h5>
                            <span>{{ user()->email }}</span>
                        </div>
                    </div>
                </div>
                <a class="dropdown-item" href="{{ url('profile') }}"><i class="fa fa-user-o"></i>
                    @lang('corals-quantum-admin::labels.partial.profile')</a>
                <a href="{{ route('logout') }}" data-action="logout"
                   class="dropdown-item">
                    <i class="fa fa-power-off"></i>
                    @lang('corals-quantum-admin::labels.partial.logout')
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- END TOP TOOLBAR WRAPPER -->
