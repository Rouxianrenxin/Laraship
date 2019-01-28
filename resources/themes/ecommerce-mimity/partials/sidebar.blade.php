<div class="list-group list-group-flush">
    <a href="#" class="list-group-item list-group-item-action"><i class="fa fa-th fa-lg fa-fw"></i>
        @lang('corals-ecommerce-mimity::labels.partial.categories')</a>
    @foreach(\Shop::getActiveCategories() as $category)
        <li class="{{ $hasChildren = $category->hasChildren()?'has-children':'' }} parent-category">
                <a href="{{ url('shop?category='.$category->slug) }}" class="list-group-item list-group-item-action sub" role="button" aria-expanded="false">
                    {{ $category->name }}
                    <span>({{ \Shop::getCategoryAvailableProducts($category->id , true) }})</span>
                </a>
        </li>
    @endforeach
    <a href="#" class="list-group-item list-group-item-action"><i
                class="fa fa-list fa-lg fa-fw"></i>@lang('corals-ecommerce-mimity::labels.partial.menu_list')
    </a>
    @include('partials.menu.menu_item',['menus'=> Menus::getMenu('frontend_top','active')])
</div>