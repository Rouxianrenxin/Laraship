<!-- Search Widget -->
<div class="widget_search">
    <form role="search" id="search-form" action="{{ url('blog') }}" method="get">
        <input type="search" class="form-control" autocomplete="off" name="query"
               placeholder="Search..." id="search-input" value="">
        <button type="submit" id="search-submit" class="search-btn"
                style="position:absolute;"><i class="lni-search"></i>
        </button>
    </form>
</div>

<!-- Categories Widget -->
<div class="widget categories">
    <h4 class="widget-title">All Categories</h4>
    <ul class="categories-list">
        @foreach(\CMS::getCategoriesList(true, 'active') as $category)
            <li>
                <a href="{{ url('category/'.$category->slug) }}">
                    {{ $category->name }}
                    <span class="category-counter">({{ \CMS::getCategoryPostsCount($category) }})</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<!-- Popular Posts widget -->
<div class="widget widget-popular-posts">
    <h4 class="widget-title">Recent Posts</h4>
    <ul class="posts-list">
        @foreach(\CMS::getLatestPosts(3) as $post)
            <li>
                @if($post->featured_image)
                    <div class="widget-thumb">
                        <a href="{{ url($post->slug) }}"><img src="{{ $post->featured_image }}" alt=""/></a>
                    </div>
                @endif
                <div class="widget-content">
                    <a href="{{ url($post->slug) }}">{{ $post->title }}</a>
                    <span><i class="icon-calendar"></i>{{ format_date($post->published_at) }}</span>
                </div>
                <div class="clearfix"></div>
            </li>
        @endforeach
    </ul>
</div>

<!-- Tag Media -->
<div class="widget tag">
    <h4 class="widget-title">Tag Cloud</h4>
    <div class="tagcloud">
        @foreach(\CMS::getTagsList(true, 'active') as $tag)
            <a class="{{ Request::is('tag/'.$tag->slug)?'active':'' }}" href="{{ url('tag/'.$tag->slug) }}">
                {{ $tag->name }}
            </a>
        @endforeach
    </div>
</div>