<header id="header" class="header fixed-top">
    <div class="container">
        <h1 class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ \Settings::get('site_logo') }}" class="" style="max-height: 30px;"/>
            </a>
        </h1><!--//logo-->
        <nav class="main-nav navbar navbar-expand-md navbar-dark" role="navigation">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                    aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar-collapse" class="navbar-collapse collapse justify-content-end">
                <div class="nav navbar-nav">
                        @include('partials.menu.menu_item', ['menus' => \Menus::getMenu('frontend_top','active')])
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-hover="dropdown" data-delay="0"
                               data-close-others="false">
                                {{ user()->name }}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ url('dashboard') }}">
                                    @lang('corals-neptune::labels.partial.dashboard')
                                </a>
                                <a class="dropdown-item" href="{{ url('profile') }}">
                                    @lang('corals-neptune::labels.partial.my_profile')
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();logout();">
                                    @lang('corals-neptune::labels.partial.logout')
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-hover="dropdown" data-delay="0"
                               data-close-others="false">
                                @lang('corals-neptune::labels.partial.account')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="authMenu">
                                <a class="dropdown-item" href="{{ route('login') }}">
                                    @lang('corals-neptune::labels.partial.login')
                                </a>
                                <a class="dropdown-item" href="{{ route('register') }}">
                                    @lang('corals-neptune::labels.partial.register')
                                </a>
                            </div>
                        </li>
                    @endauth
                    @php \Actions::do_action('post_display_frontend_menu') @endphp
                </div><!--//navabr-collapse-->
            </div>
        </nav><!--//main-nav-->
    </div><!--//container-->
</header><!--//header-->