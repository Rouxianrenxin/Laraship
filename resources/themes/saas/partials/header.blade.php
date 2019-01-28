<!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-default fixed-top">

    <div class="clearfix"></div>
    <div class="container-fluid">

        <!-- Start Top Search -->
        <div class="top-search clearfix">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Type & hit enter">
                <span class="input-group-addon close-search"><i class="ion-android-close"></i></span>
            </div>

        </div><!-- End Top Search -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="{{ url('/') }}">
            {{--<img src="{{ \Settings::get('site_logo') }}" alt="" class="logo-scroll" style="width: 10%;">--}}
            <img src="{{ \Settings::get('site_logo') }}" alt="" class="logo-top" style="width: 50%;">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                    @include('partials.menu.menu_item', ['menus' => Menus::getMenu('frontend_top','active')])
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                           id="authMenu"
                           aria-haspopup="true" aria-expanded="false">
                            {{ user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="authMenu">
                            <li>
                                <a class="dropdown-item" href="{{ url('dashboard') }}">
                                    @lang('corals-saas::labels.partial.dashboard')
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('profile') }}">
                                    @lang('corals-saas::labels.partial.profile')
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" data-action="logout">
                                    @lang('corals-saas::labels.partial.logout')
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                               id="authMenu"
                               aria-haspopup="true" aria-expanded="false">
                                @lang('corals-saas::labels.partial.account')
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="authMenu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        @lang('corals-saas::labels.partial.login')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        @lang('corals-saas::labels.partial.register')
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                        @php \Actions::do_action('post_display_frontend_menu') @endphp

            </ul>
            @if(count(\Settings::get('supported_languages', [])) > 1)
                <li class="dropdown locale" style="list-style-type: none;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {!! \Language::flag() !!} {!! \Language::getName() !!}
                    </a>
                    {!! \Language::flags('dropdown-menu') !!}
                </li>
            @endif
        </div>

    </div>
</nav><!--navbar end-->
