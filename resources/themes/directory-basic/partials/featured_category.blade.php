<section id="sec2">
    <div class="container">
        <div class="section-title">
            <h2>@lang('corals-directory-basic::labels.template.home.featured_categories')</h2>
            <div class="section-subtitle">@lang('corals-directory-basic::labels.template.home.catalog_of_categories')</div>
            <span class="section-separator"></span>
            <p>@lang('corals-directory-basic::labels.template.home.explore_some_of_the_best_tips_from_around_the_city_from_our_partners_and_friends')</p>
        </div>
        <!-- portfolio start -->
        <div class="gallery-items fl-wrap mr-bot spad">
            @foreach(\Category::getCategoriesList('Directory',false,true,'active',[],true) as $category)
                <div class="gallery-item">
                    <div class="grid-item-holder">
                        <div class="listing-item-grid">
                            <a href="{{url('listings?category='.$category->slug)}}"><img src="{{$category->thumbnail}}"
                                                                                         alt="{{$category->name}}"></a>
                            <div class="listing-counter">
                                <span>{{Corals\Modules\Directory\Facades\Directory::getCategoryListingsCount($category->id)}} </span>
                                @lang('corals-directory-basic::labels.template.home.locations')
                            </div>
                            <div class="listing-item-cat">
                                <h3><a href="{{url('listings?category='.$category->slug)}}">{{$category->name}}</a></h3>
                                <p>{{$category->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>