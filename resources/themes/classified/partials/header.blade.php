<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
                        aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="lni-menu"></span>
                    <span class="lni-menu"></span>
                    <span class="lni-menu"></span>
                </button>
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img src="{{ \Settings::get('site_logo') }}" alt="{{ \Settings::get('site_name') }}"></a>
            </div>
            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="navbar-nav mr-auto">
                    @include('partials.menu.menu_item', ['menus'=> \Menus::getMenu('frontend_top','active')])
                </ul>

                <ul class="sign-in">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <i class="lni-user"></i>
                            @auth
                                {{ user()->name }}
                                @else
                                    @lang('corals-classified-master::auth.my_account')
                                    @endauth
                        </a>
                        <div class="dropdown-menu">
                            @auth
                                <a class="dropdown-item" href="{{url('classified/user/products')}}">
                                    <i class="fa fa-cube fa-fw"></i>
                                    @lang('corals-classified-master::labels.product.my')
                                </a>
                                <a class="dropdown-item" href="{{ url('classified/user/dashboard') }}">
                                    <i class="fa fa-fw fa-dashboard"></i>@lang('corals-classified-master::auth.dashboard')
                                </a>

                                <a class="dropdown-item" href="{{ url('profile') }}">
                                    <i class="fa fa-fw fa-user-o"></i>@lang('corals-classified-master::auth.profile')
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}" data-action="logout">
                                    <i class="fa fa-fw fa-sign-out"></i> @lang('corals-classified-master::auth.logout')
                                </a>
                            @endauth
                            @guest
                                <a class="dropdown-item" href="{{ route('login') }}"><i
                                            class="lni-lock"></i>@lang('corals-classified-master::auth.login')</a>
                                <a class="dropdown-item" href="{{ route('register') }}"><i
                                            class="lni-user"></i>@lang('corals-classified-master::auth.register')</a>
                            @endguest
                        </div>
                    </li>
                </ul>
                <a class="tg-btn" href="{{url('classified/user/products/create')}}">
                    <i class="lni-pencil-alt"></i> @lang('corals-classified-master::labels.product.add')
                </a>

            </div>
        </div>

        <ul class="mobile-menu">
            @include('partials.menu.mobile_menu_item', ['menus'=> \Menus::getMenu('frontend_top','active')])
            <li>
                <a>
                    @auth
                        {{ user()->name }}
                        @else
                            @lang('corals-classified-master::auth.my_account')
                            @endauth
                </a>
                <ul class="dropdown">
                    @auth
                        <li>
                            <a href="{{url('classified/user/products')}}">

                                @lang('corals-classified-master::labels.product.my')
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('classified/user/dashboard') }}">
                                @lang('corals-classified-master::auth.dashboard')
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('profile') }}">
                                @lang('corals-classified-master::auth.profile')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" data-action="logout">
                                @lang('corals-classified-master::auth.logout')
                            </a>
                        </li>
                    @endauth
                    @guest
                        <a class="dropdown-item" href="{{ route('login') }}"><i
                                    class="lni-lock"></i>@lang('corals-classified-master::auth.login')</a>
                        <a class="dropdown-item" href="{{ route('register') }}"><i
                                    class="lni-user"></i>@lang('corals-classified-master::auth.register')</a>
                    @endguest
                </ul>

            </li>

        </ul>


    </nav>

    @yield('hero_area')
</header>
<!-- Header Area wrapper End -->


