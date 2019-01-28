@extends('layouts.master')


@section('editable_content')
    <div class="container padding-top-4x">
        <div class="row">
            <div class="col-lg-9 order-lg-2">
                <div class="text-center">
                    @php \Actions::do_action('pre_display_shop') @endphp
                </div>

                <!-- Shop Toolbar-->
                <div class="shop-toolbar padding-bottom-1x mb-2">
                    <div class="column">
                        <div class="shop-sorting">
                            <label for="sorting">@lang('corals-ecommerce-ultimate::labels.template.shop.sort')</label>

                            <select class="form-control" id="shop_sort">
                                <option disabled="disabled"
                                        selected>@lang('corals-ecommerce-ultimate::labels.template.shop.select_option')</option>
                                @foreach($sortOptions as $value => $text)
                                    <option value="{{ $value }}" {{ request()->get('sort') == $value?'selected':'' }}>
                                        {{ $text }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="text-muted">@lang('corals-ecommerce-ultimate::labels.template.shop.show')
                                &nbsp;</span>
                            <span>{{trans('corals-ecommerce-ultimate::labels.template.shop.page',['current'=>$products->currentPage(),'total' => $products->lastPage()])}}</span>
                        </div>
                    </div>
                    <div class="column">
                        <div class="shop-view">
                            <a class="grid-view {{ $layout=='grid'?'active':'' }}"
                               href="{{ request()->fullUrlWithQuery(['layout'=>'grid']) }}">
                                <span></span><span></span><span></span>
                            </a>
                            <a class="list-view {{ $layout=='list'?'active':'' }}"
                               href="{{ request()->fullUrlWithQuery(['layout'=>'list']) }}">
                                <span></span><span></span><span></span>
                            </a>
                        </div>
                    </div>
                </div>
                @isset($shopText)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            {{ $shopText }}
                        </div>
                    </div>
                @endisset
                <div id="shop-items">
                    <div class="row">
                        <!-- Product-->
                        <div class="gutter-sizer"></div>
                        <div class="grid-sizer"></div>
                        @forelse($products as $product)
                            @if($layout=='grid')
                                <div class="col-md-4 col-sm-6">
                                    @include('partials.product_'.$layout.'_item',compact('product'))
                                </div>
                            @else
                                @include('partials.product_'.$layout.'_item',compact('product'))
                            @endif
                        @empty
                            <h4>@lang('corals-ecommerce-ultimate::labels.template.shop.sorry_no_result')</h4>
                        @endforelse
                        {{ $products->appends(request()->except('page'))->links('partials.paginator') }}
                    </div>
                </div>
                <!-- Products Grid-->

                <!-- Pagination-->
            </div>
            <div class="col-lg-3 order-lg-1">
                <div class="sidebar-toggle position-left"><i class="icon-filter"></i></div>
                <aside class="sidebar sidebar-offcanvas position-left"><span class="sidebar-close"><i
                                class="icon-x"></i></span>
                    <form id="filterForm">
                        <section class="widget pt-1">
                            <input class="form-control" type="text" name="search"
                                   placeholder="@lang('corals-ecommerce-ultimate::labels.template.shop.search')"
                                   value="{{request()->get('search')}}">
                            <input type="hidden" name="sort" id="filterSort" value=""/>
                        </section>
                        <!-- Widget Categories-->
                        <section class="widget widget-categories">
                            <h3 class="widget-title">@lang('corals-ecommerce-ultimate::labels.template.shop.shop_categories')</h3>
                            <ul>
                                @foreach(\Shop::getActiveCategories() as $category)
                                    <li class="{{ $hasChildren = $category->hasChildren()?'child has-children':'' }} parent-category">
                                        @if($hasChildren)

                                            <a href="#" class="">{{ $category->name }}</a><span>({{
                                            \Shop::getCategoryAvailableProducts($category->id, true)
                                            }})</span>
                                        @else
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input"
                                                       name="category[]" value="{{ $category->slug }}"
                                                       type="checkbox"
                                                       id="ex-check-{{ $category->id }}"
                                                        {{ \Shop::checkActiveKey($category->slug,'category')?'checked':'' }}>
                                                <label class="custom-control-label"
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
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input"
                                                                   type="checkbox"
                                                                   name="category[]"
                                                                   value="{{ $child->slug }}"
                                                                   type="checkbox"
                                                                   id="ex-check-{{ $child->id }}"
                                                                    {{ \Shop::checkActiveKey($child->slug,'category')?'checked':'' }}>
                                                            <label class="custom-control-label"
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
                                <h3 class="widget-title">@lang('corals-ecommerce-ultimate::labels.template.shop.price_range')</h3>
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
                                                <div class="ui-range-value-min">$<span></span>
                                                    <input name="price[min]" type="hidden">
                                                </div>&nbsp;-&nbsp;
                                                <div class="ui-range-value-max">$<span></span>
                                                    <input name="price[max]" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                    </footer>
                                </div>
                            </section>
                    @endif

                    <!-- Widget Brand Filter-->
                        @if(!($brands = \Shop::getActiveBrands())->isEmpty())
                            <section class="widget">
                                <h3 class="widget-title">@lang('corals-ecommerce-ultimate::labels.template.shop.filter_brand')</h3>
                                @foreach($brands as $brand)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input"
                                               type="checkbox"
                                               name="brand[]" value="{{ $brand->slug }}" id="brand_{{ $brand->id }}"
                                                {{ \Shop::checkActiveKey($brand->slug,'brand')?'checked':'' }}/>
                                        <label class="custom-control-label"
                                               for="brand_{{ $brand->id }}">
                                            {{ $brand->name }}
                                            <span class="text-muted"> ({{ $brand->products_count }})</span></label>
                                    </div>
                                @endforeach
                            </section>
                        @endif
                        <section class="widget">
                            <div class="column">
                                {!! \Shop::getAttributesForFilters() !!}
                            </div>
                        </section>

                        <div class="column">
                            <button class="btn btn-outline-primary btn-block  btn-sm"
                                    type="submit">@lang('corals-ecommerce-ultimate::labels.template.shop.filter')</button>
                        </div>
                    </form>
                </aside>
                @php \Actions::do_action('post_display_ecommerce_filter') @endphp

            </div>
        </div>
    </div>




@stop
@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#shop_sort").change(function () {
                $("#filterSort").val($(this).val());

                $("#filterForm").submit();
            })
        });
    </script>
@endsection