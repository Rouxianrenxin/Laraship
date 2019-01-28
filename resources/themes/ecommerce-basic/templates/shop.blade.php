@extends('layouts.master')

@section('before_content')
    <!-- Shop Filters Modal-->
    <div class="modal fade" id="modalShopFilters" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Shop Filters</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @include('partials.shop_filter')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('editable_content')
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1 mt-5">
        <div class="row">

            <!-- Products-->
            <div class="col-xl-9 col-lg-8 order-lg-2">
                <div class="text-center">
                    @php \Actions::do_action('pre_display_shop') @endphp
                </div>
                <!-- Shop Toolbar-->
                <div class="shop-toolbar padding-bottom-1x mb-2">
                    <div class="column">
                        <div class="shop-sorting">
                            <label for="sorting">@lang('corals-ecommerce-basic::labels.template.shop.sort')</label>

                            <select class="form-control" id="shop_sort">
                                <option disabled="disabled"
                                        selected>@lang('corals-ecommerce-basic::labels.template.shop.select_option')</option>
                                @foreach($sortOptions as $value => $text)
                                    <option value="{{ $value }}" {{ request()->get('sort') == $value?'selected':'' }}>
                                        {{ $text }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="text-muted">@lang('corals-ecommerce-basic::labels.template.shop.show')
                                &nbsp;</span>
                            <span>{{trans('corals-ecommerce-basic::labels.template.shop.page',['current'=>$products->currentPage(),'total' => $products->lastPage()])}}</span>
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
                    <div class="{{ $layout == 'grid'?'isotope-grid':'' }} cols-3 mb-2">
                        <div class="gutter-sizer"></div>
                        <div class="grid-sizer"></div>
                        <!-- Product-->
                        @forelse($products as $product)
                            @include('partials.product_'.$layout.'_item',compact('product'))
                        @empty
                            <h4>@lang('corals-ecommerce-basic::labels.template.shop.sorry_no_result')</h4>
                        @endforelse
                    </div>

                    <!-- Pagination-->
                    {{ $products->appends(request()->except('page'))->links('partials.paginator') }}
                </div>
            </div>
            <!-- Sidebar          -->
            <div class="col-xl-3 col-lg-4 order-lg-1">
                <button class="sidebar-toggle position-left" data-toggle="modal" data-target="#modalShopFilters"><i
                            class="icon-layout"></i></button>
                <aside class="sidebar sidebar-offcanvas">
                    @include('partials.shop_filter')
                </aside>
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
