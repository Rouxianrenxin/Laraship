<section class="scroll-con-sec hero-section" data-scrollax-parent="true" id="sec1">
    <div class="bg" data-bg="{{ CMS::getContentFeaturedImage($item) ??  Theme::url('/images/bg/header-bg.jpg')   }}"
         data-scrollax="properties: { translateY: '200px' }"></div>
    <div class="overlay"></div>
    <div class="hero-section-wrap fl-wrap">
        <div class="container">
            <div class="intro-item fl-wrap">
                <div class="">
                    {!! $item->rendered !!}
                </div>
            </div>
            <div class="main-search-input-wrap">
                <form id="filterForm" action="{{url('listings')}}">
                    <div class="main-search-input fl-wrap">
                        <div class="main-search-input-item">
                            <input type="text" name="search"
                                   placeholder="@lang('corals-directory-basic::labels.template.listing.keywords'):"
                                   value="{{request()->get('search')}}"/>
                            <input type="hidden" name="sort" id="filterSort" value=""/>
                        </div>
                        <div class="main-search-input-item location" id="autocomplete-container">

                            <select data-placeholder="Location" name="location">
                                <option value=""
                                        selected>@lang('corals-directory-basic::labels.template.listing.location')</option>
                                @foreach( \Address::getLocationsList('Directory',true) as $location)
                                    <option value="{{$location->name}}" {{  checkActiveKey($location->slug,'location') ? "selected" : ""  }}>{{$location->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="main-search-input-item">
                            <select data-placeholder="All Categories" name="category">
                                <option value=""
                                        selected>@lang('corals-directory-basic::labels.template.listing.category')</option>
                                @foreach(\Category::getCategoriesList('Directory',false,true) as $activeCategory)
                                    <option value="{{$activeCategory->slug}}" {{ request()->input('category') == $activeCategory->slug ? "selected" : ""  }}>{{$activeCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="main-search-button" type="submit">Search
                        </button>
                    </div>
                </form>
                @php \Actions::do_action('post_display_directory_filter') @endphp
            </div>
        </div>
    </div>
    <div class="bubble-bg"></div>
    <div class="header-sec-link">
        <div class="container"><a href="#sec2"
                                  class="custom-scroll-link">@lang('corals-directory-basic::labels.dashboard.lets_start')</a>
        </div>
    </div>
</section>
