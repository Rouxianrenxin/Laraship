@extends('layouts.master')


@section('editable_content')
    <div class="container">
        <div class="row my-3">
            <aside class="col-12 widget search-widget">
                <form class="search form-inline" id="filterForm">
                    <!-- Search Form -->
                    <div class="input-group w-100">
                        <input class="form-control" type="text" name="search"
                               placeholder="@lang('corals-compo::labels.partial.search')"
                               value="{{request()->get('search')}}">
                        <input type="hidden" name="sort" id="filterSort" value=""/>
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary" aria-haspopup="true" aria-expanded="false"
                                    style="height: 44px">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-center">
                    @php \Actions::do_action('pre_display_shop') @endphp
                </div>
            </aside>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <form id="filterForm">
                    <aside class="card widget category-widget">
                        <div class="card-body">
                            <h5 class="heading">@lang('corals-compo::labels.template.shop.shop_categories')</h5>
                            <ul class="shop-categories nom" id="shop-categories">
                                @foreach(\Shop::getActiveCategories() as $category)
                                    <li class="{{ $hasChildren = $category->hasChildren()?'has-children':'' }} sub-categories">
                                        @if($hasChildren)
                                            <a href="#uniform" class="collapsed d-inline-block"
                                               data-toggle="collapse">{{ $category->name }}</a>
                                            <span>({{
                                               \Shop::getCategoryAvailableProducts($category->id, true)
                                               }})
                                               </span>
                                        @else
                                            <a href="#" class="no-childx">
                                                <input class=""
                                                       name="category[]" value="{{ $category->slug }}"
                                                       type="checkbox"
                                                       id="ex-check-{{ $category->id }}"
                                                        {{ \Shop::checkActiveKey($category->slug,'category')?'checked':'' }}>
                                                <label class=""
                                                       for="ex-check-{{ $category->id }}">
                                                    {{ $category->name }}
                                                    @if(\Shop::getCategoryAvailableProducts($category->id, true))
                                                        ({{ \Shop::getCategoryAvailableProducts($category->id, true)}})
                                                    @endif
                                                </label>
                                            </a>
                                        @endif
                                        @if($hasChildren)
                                            <ul id="uniform" class="shop-categories collapse"
                                                data-parent="#shop-categories">
                                                @foreach($category->children as $child)
                                                    <li>
                                                        <a href="#" class="">
                                                            <input class=""
                                                                   name="category[]" value="{{ $child->slug }}"
                                                                   type="checkbox"
                                                                   id="ex-check-{{ $child->id }}"
                                                                    {{ \Shop::checkActiveKey($child->slug,'category')?'checked':'' }}>
                                                            <label class=""
                                                                   for="ex-check-{{ $child->id }}">
                                                                {{ $child->name }}
                                                                @if(\Shop::getCategoryAvailableProducts($child->id, true))
                                                                    ({{
                                                                   \Shop::getCategoryAvailableProducts($child->id, true)
                                                                   }})
                                                                @endif
                                                            </label>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                    @php
                        $min = \Shop::getSKUMinPrice()??0;
                        $max= \Shop::getSKUMaxPrice()??9999999;
                    @endphp
                    @if($min !== $max )
                        <aside class="card">
                            <div class="card-body">
                                <h5 class="heading">@lang('corals-compo::labels.template.shop.price_range')</h5>
                                <div class="price-range-slider"
                                     data-min="{{ $min }}"
                                     data-max="{{ $max }}"
                                     data-start-min="{{ request()->input('price.min', $min) }}"
                                     data-start-max="{{ request()->input('price.max', $max) }}"
                                     data-step="1">
                                    <div class="ui-range-slider"></div>
                                    <footer class="ui-range-slider-footer">
                                        <div class="column">
                                            <div class="ui-range-values text-center" style="margin-top: 10px">
                                                <div class="ui-range-value-min d-inline-block">$<span></span>
                                                    <input name="price[min]" type="hidden">
                                                </div>
                                                -
                                                <div class="ui-range-value-max d-inline-block">$<span></span>
                                                    <input name="price[max]" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </aside>
                    @endif
                    <aside class="card">

                        <div class="card-body">
                            <h5 class="heading">@lang('corals-compo::labels.template.shop.filter_brand')</h5>
                            @if(!($brands = \Shop::getActiveBrands())->isEmpty())
                                <ul class="list-unstyled">
                                    @foreach($brands as $brand)
                                        <li class="">

                                            <input class="custom-control custom-radio"
                                                   name="brand[]" value="{{ $brand->slug }}"
                                                   type="checkbox" id="brand_{{ $brand->id }}"
                                                    {{ \Shop::checkActiveKey($brand->slug,'brand')?'checked':'' }}/>

                                            <span class="custom-control-indicator"></span>
                                            <label class="" for="brand_{{ $brand->id }}">{{ $brand->name }}
                                                &nbsp;<span class="text-muted">
                                            ({{ $brand->products_count }})
                                        </span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <section class="widget">
                                <div class="column">
                                    {!! \Shop::getAttributesForFilters() !!}
                                </div>
                            </section>

                            <section class="widget">
                                <div class="column">
                                    <button class="btn btn-outline-primary btn-block btn-sm"
                                            type="submit">@lang('corals-compo::labels.template.shop.filter')</button>
                                </div>
                            </section>
                        </div>

                    </aside>
                </form>
            </div>

            <div class="col-lg-9">

                <div class="shop-sorting">
                    <label for="sorting"
                           style="font-size: 15px">@lang('corals-compo::labels.template.shop.sort')</label>
                    <select class="form-control" id="shop_sort">
                        <option disabled="disabled"
                                selected>@lang('corals-compo::labels.template.shop.select_option')</option>
                        @foreach($sortOptions as $value => $text)
                            <option value="{{ $value }}" {{ request()->get('sort') == $value?'selected':'' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>

                    <span class="text-muted" style="font-size: 14px">@lang('corals-compo::labels.template.shop.show')
                        &nbsp;</span>
                    <span style="font-size: 14px">{{trans('corals-compo::labels.template.shop.page',['current'=>$products->currentPage(),'total' => $products->lastPage()])}}</span>
                </div>
                @isset($shopText)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            {{ $shopText }}
                        </div>
                    </div>
                @endisset
                <div class="row">
                    <!-- Product-->

                    @forelse($products as $product)
                        <div class="col-lg-4">
                            @include('partials.product_'.$layout.'_item',compact('product'))
                        </div>
                    @empty
                        <h4>@lang('corals-compo::labels.template.shop.sorry_no_result')</h4>
                    @endforelse

                </div>
                <div class="text-center">
                    {{ $products->appends(request()->except('page'))->links('partials.paginator') }}
                </div>

            </div>

            <!-- Pagination-->

            @php \Actions::do_action('post_display_ecommerce_filter') @endphp
        </div>
    </div>

    <!-- Footer -->

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