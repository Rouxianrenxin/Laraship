<header class="site-header main-header dark-header fs-header sticky">
    <div class="header-inner">
        <div class="logo-holder">
            <a href="{{ url('/')}}"><img src="{{ \Settings::get('site_logo') }}" style="max-width: 200px" alt=""/></a>
        </div>
        <form id="filterForm" action="{{url('listings')}}">
            <div class="header-search vis-header-search">
                <div class="header-search-input-item">
                    <input type="text" name="search"
                           placeholder="@lang('corals-directory-basic::labels.template.listing.keywords'):"
                           value="{{request()->get('search')}}"/>
                    <input type="hidden" name="sort" id="filterSort" value=""/>
                </div>

                <div class="header-search-select-item">
                    <select data-placeholder="All Categories" name="category">
                        <option selected
                                value="">@lang('corals-directory-basic::labels.template.listing.category')</option>
                        @foreach(\Category::getCategoriesList('Directory',false,true) as $activeCategory)
                            <option value="{{$activeCategory->slug}}" {{ request()->input('category') == $activeCategory->slug ? "selected" : ""  }} >{{$activeCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="header-search-button">@lang('corals-directory-basic::labels.partial.search')</button>
            </div>
        </form>
    </div>
    <div class="show-search-button"><i class="fa fa-search"></i>
        <span>@lang('corals-directory-basic::labels.partial.search')</span></div>
    <a href="{{url('directory/user/listings/create')}}"
       class="add-list">@lang('corals-directory-basic::labels.template.home.add_listing') <span><i
                    class="fa fa-plus"></i></span></a>

    <div class="header-user-menu">
        @auth
            <div class="header-user-name">
                <span><img src="{{ user()->picture_thumb }}" alt="{{ user()->name }}"></span>
                {{ user()->name }}
            </div>
            <ul>
                <li><a href="{{ url('profile') }}"> @lang('corals-directory-basic::labels.partial.my_profile')</a></li>

                @if(user() && user()->hasPermissionTo('Directory::listing.create'))
                    <li>
                        <a href="{{url('directory/user/listings/create')}}"> @lang('corals-directory-basic::labels.template.home.add_listing')</a>
                    </li>
                    <li>
                        <a href="{{url('directory/user/listings')}}"> @lang('corals-directory-basic::labels.dashboard.my_listings') </a>
                    </li>
                @endif
                <li>
                    <a href="{{url('directory/wishlist/my')}}"> @lang('corals-directory-basic::labels.dashboard.my_wishlists') </a>
                </li>
                <li><a class="dropdown-item" href="{{ user()->getDashboardURL() }}">

                        @lang('corals-directory-basic::labels.partial.dashboard')
                    </a></li>
                <li><a href="{{ route('logout') }}" data-action="logout"
                    > @lang('corals-directory-basic::labels.partial.logout')</a></li>
                @endauth
                @guest
                    <div class="header-user-name">
                        @lang('corals-directory-basic::labels.partial.my_account')
                    </div>
                    <ul>
                        <li><a class="dropdown-item"
                               href="{{ route('login') }}">@lang('corals-directory-basic::labels.partial.login')</a>
                        </li>
                        <li><a class="dropdown-item"
                               href="{{ route('register') }}">@lang('corals-directory-basic::labels.partial.register')</a>
                        </li>
                    </ul>
                @endguest
            </ul>
    </div>

    <!-- nav-button-wrap-->

    <div class="nav-button-wrap color-bg">
        <div class="nav-button">
            <span></span><span></span><span></span>
        </div>
    </div>
    <!-- nav-button-wrap end-->
    <!--  navigation -->
    <div class="nav-holder main-menu">
        <nav>
            <ul>
                @include('partials.menu.menu_item',['menus' =>  \Menus::getMenu('frontend_top','active')])
            </ul>
        </nav>
    </div>
    <!-- navigation  end -->
    </div>
</header>
