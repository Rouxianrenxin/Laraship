<form id="filterForm">
    <!-- Widget Search-->
    <section class="widget pt-1">
        <input class="form-control" type="text" name="search"
               placeholder="@lang('Marketplace::labels.shop.search')"
               value="{{request()->get('search')}}">
        <input type="hidden" name="sort" id="filterSort" value=""/>
    </section>

    <!-- Widget Categories-->
    <section class="widget widget-categories">
        <h3 class="widget-title">@lang('corals-marketplace-master::labels.template.shop.shop_categories')</h3>
        <ul>
            @foreach(\Shop::getActiveCategories() as $category)
                <li class="{{ $hasChildren = $category->hasChildren()?'has-children':'' }} parent-category">
                    @if($hasChildren)
                        <a href="#">{{ $category->name }}</a>
                        <span>({{
                                            \Shop::getCategoryAvailableProducts($category->id, true)
                                            }})
                                            </span>
                    @else
                        <div class="">
                            <input class=""
                                   name="category[]" value="{{ $category->slug }}"
                                   type="checkbox"
                                   id="ex-check-{{ $category->id }}"
                                    {{ \Shop::checkActiveKey($category->slug,'category')?'checked':'' }}>
                            <label class=""
                                   for="ex-check-{{ $category->id }}">
                                {{ $category->name }}
                                ({{ \Shop::getCategoryAvailableProducts($category->id, true)}})
                            </label>
                        </div>
                    @endif
                    @if($hasChildren)
                        <ul>
                            @foreach($category->children as $child)
                                <li>
                                    <div class="">
                                        <input class=""
                                               name="category[]" value="{{ $child->slug }}"
                                               type="checkbox"
                                               id="ex-check-{{ $child->id }}"
                                                {{ \Shop::checkActiveKey($child->slug,'category')?'checked':'' }}>
                                        <label class=""
                                               for="ex-check-{{ $child->id }}">
                                            {{ $child->name }}
                                            ({{
                                                                \Shop::getCategoryAvailableProducts($child->id, true)
                                                                }})
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </section>
@php
    $min = \Shop::getSKUMinPrice()??0;
    $max= \Shop::getSKUMaxPrice()??9999999;
@endphp
@if($min !== $max )
    <!-- Widget Price Range-->
        <section class="widget widget-categories">
            <h3 class="widget-title">@lang('corals-marketplace-master::labels.template.shop.price_range')</h3>
            <div class="price-range-slider"
                 data-min="{{ $min }}"
                 data-max="{{ $max }}"
                 data-start-min="{{ request()->input('price.min', $min) }}"
                 data-start-max="{{ request()->input('price.max', $max) }}"
                 data-step="1">
                <div class="ui-range-slider"></div>
                <footer class="ui-range-slider-footer">
                    <div class="column">
                        <div class="ui-range-values">
                            <div class="ui-range-value-min">{{ \Payments::currency_symbol() }}<span></span>
                                <input name="price[min]" type="hidden">
                            </div>&nbsp;-&nbsp;
                            <div class="ui-range-value-max">{{ \Payments::currency_symbol() }}<span></span>
                                <input name="price[max]" type="hidden">
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </section>
    @endif
    @if(!($brands = \Shop::getActiveBrands())->isEmpty())
        <section class="widget">
            <h3 class="widget-title">@lang('corals-marketplace-master::labels.template.shop.filter_brand')</h3>
            @foreach($brands as $brand)
                <div class="">
                    <input class=""
                           name="brand[]" value="{{ $brand->slug }}"
                           type="checkbox" id="brand_{{ $brand->id }}"
                            {{ \Shop::checkActiveKey($brand->slug,'brand')?'checked':'' }}/>
                    <label class="" for="brand_{{ $brand->id }}">{{ $brand->name }}
                        &nbsp;<span class="text-muted">
                                            ({{ $brand->products_count }})
                                        </span>
                    </label>
                </div>
            @endforeach
        </section>
    @endif
    <section class="widget">
        <div class="column">
            {!! \Shop::getAttributesForFilters() !!}
        </div>
    </section>

    <section class="widget">
        <div class="column">
            <button class="btn btn-outline-primary btn-block btn-sm"
                    type="submit">@lang('corals-marketplace-master::labels.template.shop.filter')</button>
        </div>
    </section>
</form>
@php \Actions::do_action('post_display_marketplace_filter') @endphp

{!!   \Shortcode::compile( 'zone','filter-sidebar' ) ; !!}