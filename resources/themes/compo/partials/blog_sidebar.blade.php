<div class="">
    <aside class="card widget search-widget mt-0">
        <div class="card-body">
            <h5 class="heading">@lang('corals-compo::labels.partial.search')</h5>
            <form role="form" action="{{ url('blog') }}">
                <div class="input-group">
                    <input type="text" name='query' class="form-control" autocomplete="off" placeholder="Search Here">
                    <span class="input-group-btn">
                                     <button class="btn btn-light" type="button" style="height: 44px;display: flex"><i
                                                 class="fa fa-search fa-fw"></i></button>
                                </span>
                </div>
            </form>
        </div>
    </aside>
    <aside class="card widget category-widget">
        <div class="card-body">
            <h5 class="heading">@lang('corals-compo::labels.partial.categories')</h5>
            <ul class="categories">
                @foreach(\CMS::getCategoriesList(true, 'active') as $category)
                    <li><a href="{{ url('category/'.$category->slug) }}">{{ $category->name }} <span
                                    class="badge">{{ \CMS::getCategoryPostsCount($category) }}</span></a></li>
                @endforeach
            </ul>
        </div>
    </aside>
    <aside class="card widget tagcloud-widget">
        <div class="card-body">
            <h5 class="heading">@lang('corals-compo::labels.partial.tag_cloud')</h5>
            <ul class="tagcloud">
                @foreach(\CMS::getTagsList(true, 'active') as $tag)
                    <li><a class="btn btn-xs btn-primary"
                           href="{{ url('tag/'.$tag->slug) }}">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>