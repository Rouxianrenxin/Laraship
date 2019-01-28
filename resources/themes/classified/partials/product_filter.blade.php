<form id="filterForm">

    <input type="hidden" name="sort" id="filterSort" value=""/>
    <input type="hidden" name="user" id="filterSort" value="{{  \Request::get('user') }}"/>

    <!-- Searcg Widget -->
    <div class="widget_search">
        <input type="search" class="form-control" autocomplete="off" name="search"
               placeholder="Search..." id="search-input" value="{{request()->get('search')}}">
        <button type="submit" id="search-submit" class="search-btn" style="position: absolute"><i
                    class="lni-search"></i>
        </button>
    </div>
    <div class="widget widget-categories">
        <h3 class="widget-title">All Categories</h3>
        <ul class="categories-list">
            @foreach(\Category::getCategoriesList('Classified', true, true, 'active') as $category)
                <li class="{{ $hasChildren = $category->hasChildren()?'has-children':'' }} parent-category">
                    @if($hasChildren)
                        <input class=""
                               name="category[]" value="{{ $category->slug }}"
                               type="checkbox"
                               id="ex-check-{{ $category->id }}" {{ checkActiveKey($category->slug,'category')?'checked':'' }}>
                        <a href="#" data-toggle="collapse" data-target="#collapse_{{$category->id}}"
                           aria-expanded="false"
                           aria-controls="collapse_{{$category->id}}" style="display:initial" }}>
                            {{ $category->name }}
                            ({{\Classified::getCategoryAvailableProducts($category->id, true)}})
                            <i class="fa" aria-hidden="true"></i>
                        </a>

                    @else
                        <div class="">
                            <input class=""
                                   name="category[]" value="{{ $category->slug }}"
                                   type="checkbox"
                                   id="ex-check-{{ $category->id }}" {{ checkActiveKey($category->slug,'category')?'checked':'' }}>
                            <label class=""
                                   for="ex-check-{{ $category->id }}">
                                {{ $category->name }}
                                ({{ \Classified::getCategoryAvailableProducts($category->id, true)}})
                            </label>
                        </div>
                    @endif
                    @if($hasChildren)
                        <ul>
                            <div id="collapse_{{$category->id}}" class="panel-collapse collapse"
                                 role="tabpanel"
                                 aria-labelledby="collapseListGroupHeading1">
                                @foreach($category->children as $child)
                                    <li class="ml-4">
                                        <div class="">
                                            <input class=""
                                                   name="category[]" value="{{ $child->slug }}"
                                                   type="checkbox"
                                                   id="ex-check-{{ $child->id }}"
                                                    {{ checkActiveKey($child->slug,'category')?'checked':'' }}>
                                            <label class=""
                                                   for="ex-check-{{ $child->id }}">
                                                {{ $child->name }}
                                                ({{ \Classified::getCategoryAvailableProducts($child->id, true) }})
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Widget Price Range-->
    @php
        $min = \Classified::getMinPrice()??0;
        $max= \Classified::getMaxPrice()??99999;
    @endphp
    @if($min !== $max )
        <section class="widget widget-categories">
            <h3 class="widget-title">@lang('corals-classified-master::labels.template.product.price_range')</h3>
            <div class="price-range-slider slider-style"
                 data-min="{{ $min  }}"
                 data-max="{{ $max }}"
                 data-start-min="{{ request()->input('price.min', $min) }}"
                 data-start-max="{{ request()->input('price.max', $max) }}"
                 data-step="1">

                <div class="ui-range-slider"></div>

                <footer class="ui-range-slider-footer mt-1">
                    <div class="ui-range-values d-flex justify-content-between">
                        <div class="ui-range-value-min">{{ \Payments::currency_symbol() }}<span></span>
                            <input name="price[min]" type="hidden">
                        </div>
                        <div class="ui-range-value-max">{{ \Payments::currency_symbol() }}<span></span>
                            <input name="price[max]" type="hidden">
                        </div>
                    </div>
                </footer>
            </div>
        </section>
@endif
<!-- Condition Filter -->
    <section class="widget widget-filter-padding">
        <div class="column">
            <div class="Show-item">
                <label for="sorting">@lang('corals-classified-master::labels.product.by_condition')</label>
                <label>
                    <select name="condition" class="form-control">
                        <option disabled="disabled"
                                selected>@lang('corals-classified-master::labels.product.select_condition')</option>
                        @foreach(\Settings::get('classified_product_condition_options',[]) as $condition_key=>$condition)
                            <option value="{{$condition_key}}" {{ request()->get('condition') == $condition_key?'selected':'' }}>
                                {{$condition}}
                            </option>
                        @endforeach
                    </select>
                </label>

            </div>
        </div>
    </section>
    <!-- Attributes Filter -->
    <section class="widget widget-filter-padding">
        <div class="column">
            {!! \Classified::getAttributesForFilters(request()->input('category')) !!}
        </div>
    </section>
    <!--Submit Button -->
    <div class="column">
        <button class="btn  btn-block m-0 tg-btn"
                type="submit">@lang('corals-classified-master::labels.template.shop.filter')
        </button>
    </div>
</form>




