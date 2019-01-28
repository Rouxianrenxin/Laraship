<div class="navbar navbar-light navbar-expand-lg" role="banner">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ \Settings::get('site_logo') }}" class="mr-2 img-fluid" style="max-width: 200px;"/>
        </a>

        <button class=" navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbar-collapse">
            <ul class="navbar-nav">
                    @include('partials.menu.menu_item', ['menus' => \Menus::getMenu('frontend_top','active')])
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                           id="authMenu"
                           aria-haspopup="true" aria-expanded="false">
                            {{ user()->name }}
                            <i class="ion-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="authMenu">
                            <li>
                                <a class="dropdown-item" href="{{ url('dashboard') }}">
                                    @lang('corals-express::labels.partial.dashboard')
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('profile') }}">
                                    @lang('corals-express::labels.partial.my_profile')
                                    </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();logout();">
                                    @lang('corals-express::labels.partial.logout')
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                               id="authMenu"
                               aria-haspopup="true" aria-expanded="false">
                                @lang('corals-express::labels.partial.account')
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="authMenu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        @lang('corals-express::labels.partial.login')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        @lang('corals-express::labels.partial.register')
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                        @php \Actions::do_action('post_display_frontend_menu') @endphp

            </ul>
        </div>
    </div>
</div>