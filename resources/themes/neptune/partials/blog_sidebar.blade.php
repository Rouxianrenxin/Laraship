<section class="widget search">
    <h3 class="sr-only title">@lang('corals-neptune::labels.partial.search_blog')</h3>
    <form class="search-blog-form" action="{{ url('blog') }}">
        <div class="form-group">
            <input type="text" name='query'  class="form-control" placeholder="Search blog...">
        </div>
        <button type="submit" class="btn btn-cta btn-cta-secondary"><i class="fa fa-search"></i></button>
    </form>
</section><!--//search-->
<section class="widget">
    <h3 class="title">@lang('corals-neptune::labels.partial.Category')</h3>
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
</section>

<section class="widget">
    <h3 class="title"> @lang('corals-neptune::labels.partial.tad_cloud')</h3>
    <ul class="list-unstyled">
        @foreach(\CMS::getTagsList(true, 'active') as $tag)
            <li class="m-2">
                <a href="{{ url('tag/'.$tag->slug) }}">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>
</section><!--/.tags-->