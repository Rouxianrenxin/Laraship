@extends('layouts.theme')



@section('hero_area')
    @include('partials.page_header')
@endsection

@section('editable_content')
    <!-- Page Content-->
    <div class="main-container section-padding">
        <div class="container">
            @php $productUser = getUserByHash(\Request::get('user')) @endphp
            @if($productUser)
                @include('partials.user_details_header',compact('productUser'))
            @endif
            <div class="row">
                <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar">
                    <aside>
                        @include('partials.product_filter')
                    </aside>
                </div>

                <div class="col-lg-9 col-md-12 col-xs-12 page-content">
                    <!-- Product filter Start -->

                    <div class="product-filter">
                        <div class="short-name">

                            <span>{{trans('corals-classified-master::labels.template.product.pagination_result',['current'=>$products->currentPage(),'total' => $products->lastPage()])}}</span>

                        </div>
                        <div class="Show-item">
                            <label for="sorting">@lang('corals-classified-master::labels.template.product.sort_by')</label>
                            <label>
                                <select name="order" class="orderby form-control" id="product_sort">
                                    <option disabled="disabled"
                                            selected>@lang('corals-classified-master::labels.template.product.select_option')</option>
                                    @foreach($sortOptions as $value => $text)
                                        <option value="{{ $value }}" {{ request()->get('sort') == $value?'selected':'' }}>
                                            {{ $text }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                        </div>
                        <ul class="nav nav-tabs ignore-url-hash">
                            <li class="nav-item">
                                <a class="nav-link {{$layout=='grid'?'active':''}}"
                                   href="#grid-view"><i class="lni-grid"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$layout=='list'?'active':''}}"
                                   href="#list-view"><i class="lni-list"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="adds-wrapper">
                        <div class="tab-content">
                            <div id="grid-view" class="tab-pane fade {{ $layout == 'grid'?'active show':'' }}">
                                <div class="d-flex flex-wrap justify-content-between">
                                    @forelse($products as $product)
                                        @include('partials.product_grid_item', ['item_class'=>'two-columns', 'product'=> $product])
                                    @empty
                                        <h4>@lang('corals-classified-master::labels.template.product.sorry_no_result')</h4>
                                    @endforelse
                                </div>
                            </div>
                            <div id="list-view" class="tab-pane fade {{ $layout == 'list'?'active show':'' }}">
                                <div class="d-flex flex-wrap justify-content-between">
                                    @forelse($products as $product)
                                        @include('partials.product_list_item', ['item_class'=>'two-columns', 'product'=> $product])
                                    @empty
                                        <h4>@lang('corals-classified-master::labels.template.product.sorry_no_result')</h4>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ $products->appends(request()->except('page'))->links('partials.paginator') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    @parent

    <script type="text/javascript">
        $(document).ready(function () {
            $("#product_sort").change(function () {
                $("#filterSort").val($(this).val());

                $("#filterForm").submit();
            });

            let hash = window.location.hash;

            if (hash.length) {

                let hasURLParameters = hash.indexOf('?');//-1 if not exist
                let indexOfHash = hash.indexOf('#');

                if (hasURLParameters && hasURLParameters > indexOfHash) {
                    hash = _.split(hash, '?')[0];
                }

                $('.pagination .page-link').each(function () {
                    let href = $(this).prop('href');
                    href = _.trim(href, '#');
                    $(this).prop('href', href + hash);
                });
            }

            $('a.nav-link').on('shown.bs.tab', function (e) {
                let href = $(this).prop('href');

                let hash = '';

                let indexOfHash = href.indexOf('#');

                if (indexOfHash) {
                    hash = '#' + _.split(href, '#')[1];

                    $('.pagination .page-link').each(function () {
                        let phref = $(this).prop('href');

                        phref = _.trim(phref, '#');

                        phref = _.split(phref, '#')[0];

                        $(this).prop('href', phref + hash);
                    });
                }
            })
        });
    </script>
@endsection