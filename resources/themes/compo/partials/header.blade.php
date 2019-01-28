<header class="header-1">            <!-- Header = Topbar + Navigation Bar -->
    <div class="topbar-wrapper">
        <div class="container">            <!-- Dark Blue Topbar -->
            <div class="topbar">
                <div>
                    <a class="" href="tel:{{ \Settings::get('contact_mobile','+970599593301') }}">
                        Call us : {{ \Settings::get('contact_mobile','+970599593301') }}
                    </a><!-- Change Topbar Contact Number here -->
                </div>
                <div class="text-right">
                    <ul class="topbar-widgets menu-header">
                        <!-- Topbar Widgets - Cart, Language Select & Login Signup -->
                        <li>
                            <div class="topbar-column">
                                <ul class="list-unstyled currencies" style="display: inline-block;">
                                    @php \Actions::do_action('post_display_frontend_menu') @endphp
                                </ul>
                            </div>
                        </li>
                        <li>
                             <span class="cart">
                                <a href="{{ url('cart') }}"></a>
                                <i class="fa fa-shopping-cart fa-fw"></i>
                                <span class="count" style="border-right: 1px solid;padding-right: 14px;"
                                      id="cart-header-count">{{ count(\ShoppingCart::getItems()) }}</span>
                                <span class="subtotal" style="padding-left: 10px" id="cart-header-total">
                                 {{ \ShoppingCart::total() }}
                               </span>
                             </span>
                        </li>
                        @if(count(\Settings::get('supported_languages', [])) > 1)
                            <li class="dropdown locale hidden-sm">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    {!! \Language::flag() !!} {!! \Language::getName() !!}
                                </a>
                                {!! \Language::flags('dropdown-menu') !!}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">         <!-- Navigation Bar -->
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ \Settings::get('site_logo_white') }}" style="max-width: 200px" alt=""/>
                <!-- Replace with your Logo -->
            </a>

            <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#main-navigation"
                    aria-expanded="false">
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-bars"></i>          <!-- Mobile Navigation Toggler Icon -->
                    </span>
            </button>


            <div class="navbar-collapse justify-content-end collapse " id="main-navigation">         <!-- Main Menu -->
                <ul class="navbar-nav">
                    @include('partials.menu.menu_item', ['menus' => Menus::getMenu('frontend_top','active'),'sub' => false])

                    <li class="nav-item has-menu">
                        <a class="nav-link" href="#">
                            @auth
                                {{ user()->name }}
                            @else
                                @lang('corals-compo::labels.partial.account')
                            @endauth
                        </a>
                        <div class="sub-menu">
                            <ul class="menu-list">
                                @auth
                                    <li class="">
                                        <a class=""
                                           href="{{ url('dashboard') }}">
                                            @lang('corals-compo::labels.partial.dashboard')</a>
                                    </li>
                                    <li class="">
                                        <a class="" href="{{ route('logout') }}"
                                           data-action="logout">
                                            @lang('corals-compo::labels.partial.logout')</a>
                                    </li>
                                @else
                                    <li class="">
                                        <a class="" href="{{ route('login') }}">
                                            @lang('corals-compo::labels.partial.login')
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="" href="{{ route('register') }}">
                                            @lang('corals-compo::labels.partial.register')
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>