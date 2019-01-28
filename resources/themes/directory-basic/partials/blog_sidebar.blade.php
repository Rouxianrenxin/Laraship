<div class="box-widget-wrap">
    <!--box-widget-item -->
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>@lang('corals-directory-basic::labels.blog.Search blog') :</h3>
        </div>
        <div class="box-widget search-widget">
            <form action="{{ url('blog') }}" method="get" class="fl-wrap">
                <input name="query" id="se" type="text" class="search" placeholder="@lang('corals-directory-basic::labels.blog.Search blog')"
                />
                <button class="search-submit" id="submit_btn"><i
                            class="fa fa-search transition"></i></button>
            </form>
        </div>
    </div>
    <!--box-widget-item end -->
    <!--box-widget-item -->
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>@lang('corals-directory-basic::labels.partial.tag_cloud') :</h3>
        </div>
        <div class="list-single-tags tags-stylwrap">
            @foreach(\CMS::getTagsList(true,'active') as $tag)
                <a class="{{ Request::is('tag/'.$tag->slug)?'active':'' }}" href="{{url('tag/'.$tag->slug)}}">{{$tag->name}}</a>
            @endforeach
        </div>
    </div>
    <!--box-widget-item end -->
    <!--box-widget-item -->
    <!--box-widget-item -->
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>@lang('corals-directory-basic::labels.partial.categories') :</h3>
        </div>
        <div class="box-widget">
            <div class="box-widget-content">
                <ul class="cat-item">
                    @foreach(\CMS::getCategoriesList(true,'active') as $category)
                        <li><a href="{{url('category/'.$category->slug)}}">{{$category->name}}</a>
                            <span>({{\CMS::getCategoryPostsCount($category)}})</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!--box-widget-item end -->
</div>