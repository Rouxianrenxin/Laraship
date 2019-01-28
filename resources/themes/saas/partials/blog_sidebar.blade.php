<div class="sidebar-widget margin-b-40">
    <div class="search-form">
        <form role="form" action="{{ url('blog') }}">
            <input type="text" name='query' class="form-control search_box" autocomplete="off"
                   placeholder="Search Here">
            <button type="submit"><i class="ion-search"></i></button>
        </form>
    </div>
</div><!--/.search-->

<div class="sidebar-widget margin-b-40">
    <h4><i class="ion-android-folder-open"></i> @lang('corals-saas::labels.partial.category')</h4>
    <ul class="list-unstyled">
        @foreach(\CMS::getCategoriesList(true, 'active') as $category)
            <li><a href="{{ url('category/'.$category->slug) }}">
                    {{ $category->name }}
                    {{ \CMS::getCategoryPostsCount($category) }}
                </a>
            </li>
        @endforeach
    </ul>
</div><!--/.categories-->

<div class="sidebar-widget margin-b-40">
    <h4><i class="ion-ios-pricetag"></i> @lang('corals-saas::labels.partial.tag_cloud')</h4>
    <ul class="list-unstyled">
        @foreach(\CMS::getTagsList(true, 'active') as $tag)
            <li><a href="{{ url('tag/'.$tag->slug) }}">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div><!--/.tags-->