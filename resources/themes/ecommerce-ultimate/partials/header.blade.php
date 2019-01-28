<header class="site-header navbar-sticky">
    <!-- Topbar-->
    <div class="topbar d-flex justify-content-between">
        <!-- Logo-->
        <div class="site-branding d-flex">
            <a class="site-logo align-self-center" href="{{ url('/') }}">
                <img src="{{ \Settings::get('site_logo') }}" style="max-width: 200px" alt=""/>
            </a>
        </div>
        <!-- Search / Categories-->
        <div class="search-box-wrap d-flex">
            <div class="search-box-inner align-self-center">
                <div class="search-box d-flex">
                    <div class="btn-group categories-btn">
                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i
                                    class="icon-menu text-lg"></i> @lang('corals-ecommerce-ultimate::labels.partial.categories')
                        </button>
                        @php $categories = \Shop::getFeaturedCategories(); @endphp

                        @if(!$categories->isEmpty())
                            <div class="dropdown-menu mega-dropdown">

                                <div class="row">
                                    @foreach($categories as $category)
                                        <div class="col-sm-3">
                                            <a class="d-block navi-link text-center mb-30"
                                               href="{{ url('shop?category='.$category->slug) }}"><img class="d-block"
                                                                                                       src="{{ $category->thumbnail }}">
                                                <span class="text-gray-dark">{{$category->name}}</span></a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <a class="btn btn-outline-secondary margin-top-none" href="{{ url('shop') }}">
                                            @lang('corals-ecommerce-ultimate::labels.partial.all_categories')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <form class="input-group" method="get" action="{{ url('shop') }}">
                        <span class="input-group-btn">
                           <button type="submit" aria-haspopup="true" aria-expanded="false">
                           <i class="icon-search"></i></button>
                        </span>
                        <input class="form-control"
                               type="text" name="search"
                               value="{{ request()->get('search') }}"
                               placeholder="@lang('corals-ecommerce-ultimate::labels.partial.search')">
                    </form>
                </div>
            </div>
        </div>
        <!-- Toolbar-->
        <div class="toolbar d-flex">
            <div class="toolbar-item visible-on-mobile mobile-menu-toggle">
                <a href="#">
                    <div><i class="icon-menu"></i><span class="text-label">Menu</span></div>
                </a></div>
            <div class="toolbar-item hidden-on-mobile">
                <a href="#">
                    <div><i class="fa fa-globe"></i></div>
                </a>
                <ul class="toolbar-dropdown lang-dropdown">
                    <li class="px-6 pt-1 pb-2 text-center">
                        <ul class="list-unstyled currencies" style="display: inline-block;">
                            @php \Actions::do_action('post_display_frontend_menu') @endphp
                        </ul>
                    </li>
                    <li class="dropdown-divider"></li>
                    @if(count(\Settings::get('supported_languages', [])) > 1)
                        <li class="dropdown locale" style="list-style-type: none;display: inline-block">
                            {!! \Language::flags('list-unstyled') !!}
                        </li>
                    @endif
                </ul>
            </div>

            <div class="toolbar-item hidden-on-mobile">
                <a href="#">
                    <div>
                        <i class="icon-user"></i>
                        <span class="text-label">
                            @auth
                                {{user()->name}}
                            @else
                                @lang('corals-ecommerce-ultimate::labels.partial.login_register')
                            @endauth</span>
                    </div>
                </a>
                <div class="toolbar-dropdown text-center px-3">
                    <ul class="" style="padding: 0px;list-style: none">
                        @auth
                            <li class="sub-menu-user">
                                <div class="user-ava">
                                    <img src="{{ user()->picture_thumb }}"
                                         alt="{{ user()->name }}">
                                </div>
                                <div class="user-info">
                                    <h6 class="user-name">{{ user()->name }}</h6>
                                    <span class="text-xs text-muted">
                                       @lang('corals-ecommerce-ultimate::labels.partial.member_since')
                                        <br/>
                                        {{ format_date(user()->created_at) }}
                                    </span>
                                </div>
                            </li>

                            <li>
                                <a class="btn btn-primary btn-sm btn-block"
                                   href="{{ url('dashboard') }}">@lang('corals-ecommerce-ultimate::labels.partial.dashboard')</a>
                            </li>
                            <li>
                                <a class="btn btn-primary btn-sm btn-block"
                                   href="{{ url('profile') }}">@lang('corals-ecommerce-ultimate::labels.partial.my_profile')</a>
                            </li>
                            <li class="sub-menu-separator"></li>
                            <li><a href="{{ route('logout') }}"
                                   data-action="logout">@lang('corals-ecommerce-ultimate::labels.partial.logout')</a>
                            </li>
                        @else
                            <a class="btn btn-primary btn-sm btn-block"
                               href="{{ route('login') }}">@lang('corals-ecommerce-ultimate::labels.partial.login')</a>
                            <p class="text-xs text-muted mb-2">New customer?&nbsp;<a
                                        href="{{ route('register') }}">@lang('corals-ecommerce-ultimate::labels.partial.register')</a>
                            </p>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="toolbar-item">
                <a href="{{ url('cart') }}">
                    <div>
                        <span class="cart-icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="count-label" id="cart-header-count">{{ count(\ShoppingCart::getItems()) }}
                            </span>
                        </span>
                        <span class="text-label" id="cart-header-total">{{ \ShoppingCart::total() }}</span>
                    </div>
                </a>

            </div>
        </div>
        <!-- Mobile Menu-->
        <div class="mobile-menu">
            <!-- Search Box-->
            <div class="mobile-search">
                <form class="input-group" method="get" action="{{ url('shop') }}"><span class="input-group-btn">
                <button type="submit"><i class="icon-search"></i></button></span>
                    <input class="form-control" type="text" name="search"
                           value="{{ request()->get('search') }}"
                           placeholder="@lang('corals-ecommerce-ultimate::labels.partial.search')">
                </form>
            </div>
            <!-- Toolbar-->
            <div class="toolbar">
                <div class="toolbar-item"><a href="#">
                        <div>{!! \Language::flag() !!} {!! \Language::getName() !!}</div>
                    </a>
                    <ul class="toolbar-dropdown lang-dropdown w-100">
                        <li class="px-6 pt-1 pb-2 text-center">
                            <ul class="list-unstyled currencies" style="display: inline-block;">
                                @php \Actions::do_action('post_display_frontend_menu') @endphp
                            </ul>
                        </li>
                        @if(count(\Settings::get('supported_languages', [])) > 1)
                            <li class="dropdown locale" style="list-style-type: none;display: inline-block">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    {!! \Language::flag() !!} {!! \Language::getName() !!}
                                </a>
                                {!! \Language::flags('dropdown-menu') !!}

                            </li>
                        @endif
                    </ul>
                </div>

                <div class="toolbar-item">
                    <a href="#">
                        <div><i class="icon-user"></i><span class="text-label">
                                @auth
                                    {{user()->name}}
                                @else
                                    Login / Register
                                @endauth
                            </span></div>
                    </a>
                    <div class="toolbar-dropdown text-center px-3">
                        <ul class="" style="padding: 0px;list-style: none">
                            @auth
                                <li class="sub-menu-user">
                                    <div class="user-ava">
                                        <img src="{{ user()->picture_thumb }}"
                                             alt="{{ user()->name }}">
                                    </div>
                                    <div class="user-info">
                                        <h6 class="user-name">{{ user()->name }}</h6>
                                        <span class="text-xs text-muted">
                                       @lang('corals-ecommerce-ultimate::labels.partial.member_since')
                                            <br/>
                                            {{ format_date(user()->created_at) }}
                                    </span>
                                    </div>
                                </li>

                                <li>
                                    <a class="btn btn-primary btn-sm btn-block"
                                       href="{{ url('dashboard') }}">@lang('corals-ecommerce-ultimate::labels.partial.dashboard')</a>
                                </li>
                                <li>
                                    <a class="btn btn-primary btn-sm btn-block"
                                       href="{{ url('profile') }}">@lang('corals-ecommerce-ultimate::labels.partial.my_profile')</a>
                                </li>
                                <li class="sub-menu-separator"></li>
                                <li><a href="{{ route('logout') }}"
                                       data-action="logout">@lang('corals-ecommerce-ultimate::labels.partial.logout')</a>
                                </li>
                            @else
                                <a class="btn btn-primary btn-sm btn-block"
                                   href="{{ route('login') }}">Login</a>
                                <p class="text-xs text-muted mb-2">New customer?&nbsp;<a
                                            href="{{ route('register') }}">Register</a>
                                </p>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Slideable (Mobile) Menu-->
            <nav class="slideable-menu">
                <ul class="menu" data-initial-height="385">
                    @include('partials.menu.mobile_menu_item', ['menus' => Menus::getMenu('frontend_top','active')])
                </ul>
            </nav>
        </div>
    </div>
    <!-- Navbar-->

    <div class="navbar">
        <div class="btn-group categories-btn" style="margin-top: 15px">
            <a class="site-logo align-self-center" href="{{ url('/') }}">
                <img src="{{ \Settings::get('site_logo') }}" style="max-width: 200px" alt=""/>
            </a>
            <div class="dropdown-menu mega-dropdown">
                <div class="row">

                </div>
                <div class="row">

                </div>
            </div>
        </div>
        <!-- Main Navigation-->
        <nav class="site-menu">
            <ul>

                @include('partials.menu.menu_item', ['menus' => Menus::getMenu('frontend_top','active')])
            </ul>
        </nav>
    </div>
</header>
