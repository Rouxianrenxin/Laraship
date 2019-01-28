<div class="search">
    <form role="form" action="{{ url('blog') }}">
        <span class="icomoon-search"></span>
        <input type="text" name='query' autocomplete="off"
               placeholder="Search Here">
    </form>
</div><!--/.search-->
<div>
    <strong><i class="ion-android-folder-open"></i> @lang('corals-express::labels.partial.category')</strong>
    <ul class="list-unstyled">
        @foreach(\CMS::getCategoriesList(true, 'active') as $category)
            <li class="m-2">
                <a href="{{ url('category/'.$category->slug) }}">
                    {{ $category->name }}
                    {{ \CMS::getCategoryPostsCount($category) }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div>
    <strong><i class="ion-ios-pricetag"></i> @lang('corals-express::labels.partial.tag_cloud')</strong>
    <ul class="list-unstyled">
        @foreach(\CMS::getTagsList(true, 'active') as $tag)
            <li class="m-2">
                <a href="{{ url('tag/'.$tag->slug) }}">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div><!--/.tags-->