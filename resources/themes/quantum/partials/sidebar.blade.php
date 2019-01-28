<!-- START MENU SIDEBAR WRAPPER -->
<aside class="sidebar sidebar-left">
    <div class="sidebar-content">
        <div class="aside-toolbar">
            <ul class="site-logo">
                <li>
                    <!-- START LOGO -->
                    <a href="{{ url('/') }}">
                        <div class="logo">
                            <img src="{{ \Settings::get('site_logo_white') }}" alt="{{ \Settings::get('site_name') }}"
                                 class="dark-logo"/>
                        </div>
                    </a>
                    <!-- END LOGO -->
                </li>
            </ul>
        </div>
        <nav class="main-menu">
            <ul class="nav metismenu">
                <li class="nav-dropdown {{ \Request::is('dashboard')?'active':'' }}">
                    <a class="waves-effect waves-dark" href="{{ url('dashboard') }}">
                         @lang('corals-quantum-admin::labels.partial.dashboard')
                    </a>
                </li>
                @include('partials.menu.menu_item', ['menus'=>Menus::getMenu('sidebar','active') ])
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR WRAPPER -->