<!-- Off-Canvas Mobile Menu-->
<div class="offcanvas-container" id="mobile-menu">
    @auth
        <a class="account-link" href="{{ url('profile') }}">
            <div class="user-ava">
                <img src="{{ user()->picture_thumb }}" alt="Daniel Adams">
            </div>
            <div class="user-info">
                <h6 class="user-name">{{ user()->name }}</h6>
                <span class="text-sm text-white opacity-60">
                    @lang('corals-ecommerce-basic::labels.partial.member_since')
                    <br/>
                    {{ format_date(user()->created_at) }}
                </span>
            </div>
        </a>
    @endauth
    <nav class="offcanvas-menu">
        <ul class="menu">

                @include('partials.menu.mobile_menu_item', ['menus' => Menus::getMenu('frontend_top','active')])

            <li class="has-children">
                <span><a href="#"><span> @lang('corals-ecommerce-basic::labels.partial.account')</span></a>
                    <span class="sub-menu-toggle"></span>
                </span>
                <ul class="offcanvas-submenu">
                    @auth
                        <li>
                            <a href="{{ url('dashboard') }}">@lang('corals-ecommerce-basic::labels.partial.dashboard')</a>
                        </li>
                        <li>
                            <a href="{{ url('profile') }}">@lang('corals-ecommerce-basic::labels.partial.my_profile')</a>
                        </li>
                        <li class="sub-menu-separator"></li>
                        <li><a href="{{ route('logout') }}"
                               data-action="logout">@lang('corals-ecommerce-basic::labels.partial.logout')</a>
                        </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}">
                                    <i class="fa fa-sign-in fa-fw"></i>
                                    @lang('corals-ecommerce-basic::labels.partial.login')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">
                                    <i class="fa fa-user fa-fw"></i>
                                    @lang('corals-ecommerce-basic::labels.partial.register')
                                </a>
                            </li>
                            @endauth
                </ul>
            </li>
        </ul>
    </nav>
</div>
<!-- Topbar-->
<div class="topbar">
    <div class="topbar-column">
        <a class="hidden-md-down" href="mailto:{{ \Settings::get('contact_form_email','support@corals.io') }}">
            <i class="fa fa-envelope-o"></i>&nbsp;
            {{ \Settings::get('contact_form_email','support@corals.io') }}
        </a>
        <a class="hidden-md-down" href="tel:{{ \Settings::get('contact_mobile','+970599593301') }}"><i
                    class="fa fa-mobile"></i>
            &nbsp; {{ \Settings::get('contact_mobile','+970599593301') }}
        </a>
        @foreach(\Settings::get('social_links',[]) as $key=>$link)
            <a class="social-button sb-{{ $key }} shape-none sb-dark" href="{{ $link }}" target="_blank"><i
                        class="fa fa-{{ $key }}"></i></a>
        @endforeach
    </div>

    <div class="topbar-column">

        <ul class="list-unstyled currencies" style="display: inline-block;">
            @php \Actions::do_action('post_display_frontend_menu') @endphp
        </ul>
        @if(count(\Settings::get('supported_languages', [])) > 1)
            <li class="dropdown locale" style="list-style-type: none;display: inline-block">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {!! \Language::flag() !!} {!! \Language::getName() !!}
                </a>
                {!! \Language::flags('dropdown-menu') !!}

            </li>
        @endif
    </div>

</div>
<!-- Navbar-->
<!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
<header class="navbar navbar-sticky">
    <!-- Search-->
    <form class="site-search" method="get" action="{{ url('shop') }}">
        <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Type to search..."/>

        <div class="search-tools"><span
                    class="clear-search"> @lang('corals-ecommerce-basic::labels.partial.clear')</span>
            <span class="close-search"><i class="icon-cross"></i></span>
        </div>
    </form>
    <div class="site-branding">
        <div class="inner">
            <!-- Off-Canvas Toggle (#mobile-menu)-->
            <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
            <!-- Site Logo-->
            <a class="site-logo" href="{{ url('/') }}">
                <img src="{{ \Settings::get('site_logo') }}" alt="{{ \Settings::get('site_name', 'Corals') }}">
            </a>
        </div>
    </div>
    <!-- Main Navigation-->
    <nav class="site-menu">
        <ul>
           @include('partials.menu.menu_item', ['menus' => Menus::getMenu('frontend_top','active')])
        </ul>
    </nav>
    <!-- Toolbar-->
    <div class="toolbar">
        <div class="inner">
            <div class="tools">
                <div class="search"><i class="icon-search"></i></div>
                <div class="account">
                    <a href="#"></a><i class="icon-head"></i>
                    <ul class="toolbar-dropdown">
                        @auth
                            <li class="sub-menu-user">
                                <div class="user-ava">
                                    <img src="{{ user()->picture_thumb }}"
                                         alt="{{ user()->name }}">
                                </div>
                                <div class="user-info">
                                    <h6 class="user-name">{{ user()->name }}</h6>
                                    <span class="text-xs text-muted">
                                       @lang('corals-ecommerce-basic::labels.partial.member_since')
                                        <br/>
                                        {{ format_date(user()->created_at) }}
                                    </span>
                                </div>
                            </li>
                            <li>
                                <a href="{{ url('dashboard') }}">@lang('corals-ecommerce-basic::labels.partial.dashboard')</a>
                            </li>
                            <li>
                                <a href="{{ url('profile') }}">@lang('corals-ecommerce-basic::labels.partial.my_profile')</a>
                            </li>
                            <li class="sub-menu-separator"></li>
                            <li><a href="{{ route('logout') }}" data-action="logout">
                                    @lang('corals-ecommerce-basic::labels.partial.logout') <i
                                            class="fa fa-sign-out fa-fw"></i></a>
                            </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}">
                                        <i class="fa fa-sign-in fa-fw"></i>
                                        @lang('corals-ecommerce-basic::labels.partial.login')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}">
                                        <i class="fa fa-user fa-fw"></i>
                                        @lang('corals-ecommerce-basic::labels.partial.register')
                                    </a>
                                </li>
                                @endauth
                    </ul>
                </div>
                <div class="cart"><a href="{{ url('cart') }}"></a>
                    <i class="fa fa-shopping-cart fa-fw"></i>
                    <span class="count" id="cart-header-count">{{ count(\ShoppingCart::getItems()) }}</span>
                    <span class="subtotal" id="cart-header-total">
                        {{ \ShoppingCart::total() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>