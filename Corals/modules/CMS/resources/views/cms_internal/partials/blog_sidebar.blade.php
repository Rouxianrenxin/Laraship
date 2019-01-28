<div class="">
    <form role="form" class="form-horizontal" action="{{ url('cms/blog') }}">
        <div class="input-group">
            <input type="text" name='query' class="form-control" autocomplete="off"
                   placeholder="@lang('CMS::labels.cms_internal.search_placeholder')">
            <span class="input-group-btn">
                    <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                </span>
        </div>
    </form>
</div><!--/.search-->

<div class="">
    <h4><i class="fa fa-folder-open-o"></i> @lang('CMS::labels.cms_internal.categories')</h4>
    <ul class="list-unstyled">
        @foreach(\CMS::getCategoriesList(true, 'active', true) as $category)
            <li><a href="{{ url('cms/category/'.$category->slug) }}">
                    {{ $category->name }}
                    ({{ \CMS::getCategoryPostsCount($category, true) }})
                </a>
            </li>
        @endforeach
    </ul>
</div><!--/.categories-->

@if(!empty($tags = \CMS::getTagsList(true, 'active')))
    <div class="">
        <h4><i class="fa fa-tag"></i> @lang('CMS::labels.cms_internal.tags')</h4>
        <ul class="list-unstyled">
            @foreach($tags as $tag)
                <li><a href="{{ url('cms/tag/'.$tag->slug) }}">
                        {{ $tag->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div><!--/.tags-->
@endif
