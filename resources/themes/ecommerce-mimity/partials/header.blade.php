<header class="navbar navbar-expand navbar-light fixed-top">

    <!-- Toggle Menu -->
    <span class="toggle-menu"><i class="fa fa-bars fa-lg"></i></span>

    <!-- Logo -->
    <a class="navbar-brand"
       href="{{ url('/')}}">
        <img src="{{ \Settings::get('site_logo') }}" alt="{{ \Settings::get('site_name') }}">
    </a>

    <!-- Search Form -->
    <form class="form-inline form-search d-none d-sm-inline" method="get" action="{{ url('shop') }}">
        <div class="input-group">
            <button class="btn btn-light btn-search-back" type="button"><i class="fa fa-arrow-left"></i></button>
            <input class="form-control" type="text" name="search"
                   placeholder="@lang('Ecommerce::labels.shop.search')"
                   value="{{request()->get('search')}}">
            <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <!-- /Search Form -->

    <!-- navbar-nav -->
    <ul class="navbar-nav ml-auto">

        <!-- Currency Dropdown -->
        <li class="nav-item dropdown d-none d-md-flex">
            @php \Actions::do_action('post_display_frontend_menu') @endphp
        </li>
        <li class="nav-item cart cart-menu">
            <a href="{{ url('cart') }}">
                <i class="fa fa-2x fa-shopping-cart"></i>
                <span class="label label-success cart_total_label"
                      id="cart-header-total">{{ \ShoppingCart::total() }}</span>
            </a>
        </li>
        <!-- /Currency Dropdown -->
        @if(count(\Settings::get('supported_languages')) > 1)
            <li class="nav-item dropdown d-none d-md-flex">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownLanguage" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    {!! \Language::flag() !!} {!! \Language::getName() !!}<i class="fa fa-caret-down fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLanguage">
                    {!! \Language::flags('language-dropdown-menu','dropdown-item') !!}
                </div>
            </li>
        @endif
    <!-- /Language Dropdown -->
        <li class="nav-item d-sm-none">
            <a href="#" class="nav-link" id="search-toggle"><i class="fa fa-search fa-lg"></i></a>
        </li>
        @if(schemaHasTable('notificatios'))
            <li class="nav-item dropdown ml-1 ml-sm-3">
                <a class="nav-link dropdown-toggle" href="{{ url('notifications') }}" role="button" id="dropdownNotif"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell fa-lg"></i>
                    @if($unreadNotifications = user()->unreadNotifications()->count())
                        <span class="badge badge-info badge-count">{{ $unreadNotifications }}</span>
                    @endif
                </a>
            </li>
    @endif
    <!-- /Notification Dropdown -->

        <!-- Login Button -->
        <!-- <li class="nav-item ml-4">
          <a href="login.html" class="nav-link btn btn-light btn-sm"><i class="fa fa-sign-in"></i> Login</a>
        </li> -->
        <!-- /Login Button -->

    </ul>
    <!-- /navbar-nav -->

    <!-- User Dropdown -->
    <div class="dropdown dropdown-user">
        @auth
            <a class="dropdown-toggle" href="#" role="button" id="userDropdown" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <img src="{{ user()->picture_thumb }}" alt="User">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item has-icon has-badge m-l-5" href="{{ url('dashboard') }}">
                    @lang('corals-ecommerce-mimity::labels.partial.dashboard')
                </a>
                <a class="dropdown-item has-icon m-l-5" href="{{ url('profile') }}">
                    @lang('corals-ecommerce-mimity::labels.partial.my_profile')
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item has-icon" href="{{ route('logout') }}"
                   data-action="logout">
                    <i class="fa fa-sign-out fa-fw"></i>@lang('corals-ecommerce-mimity::labels.partial.logout')</a>
            </div>

            @else
                <a class="dropdown-toggle" href="#" role="button" id="userDropdown" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" style="display: inline;color: #869099; ">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                    Account
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item has-icon" href="{{ route('login') }}">
                        @lang('corals-ecommerce-mimity::labels.partial.login')
                    </a>
                    <a class="dropdown-item has-icon has-badge m-l-5" href="{{ route('register') }}">
                        @lang('corals-ecommerce-mimity::labels.partial.register')
                    </a>
                </div>
                @endauth
    </div>
    <!-- /User Dropdown -->

</header>
<!-- /Header -->