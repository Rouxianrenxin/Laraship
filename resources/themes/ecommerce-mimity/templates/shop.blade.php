@extends('layouts.master')

@section('editable_content')
    @include('partials.shop_filter')
    <div class="text-center">
        @php \Actions::do_action('pre_display_shop') @endphp
    </div>
    @if($category = request()->get('category'))
        @php $category = \Corals\Modules\Ecommerce\Models\Category::where('slug','=',$category)->first() @endphp
    @endif
    @if($category)
        <div class="card border-0 mb-3">
            <img src="{{ Theme::url('img/1-wide.jpeg')}}" alt="" class="card-img">
            <div class="card-img-overlay">
                <h2 class="card-title text-white title">{{ $category->name }}</h2>
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-between">
        @if($category && $category->children)
            <div class="btn-tags">
                @foreach($category->children as $child)
                    <a href="{{ url('shop?category='.$child->slug) }}"
                       class="btn btn-light btn-sm active">{{ $child->name }}</a>
                @endforeach
            </div>
        @endif
        <span>
                  <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#filterModal"><i
                              class="fa fa-filter"></i> @lang('corals-ecommerce-mimity::labels.template.shop.filter')</button>
                </span>
    </div>
    <div class="shop-toolbar padding-bottom-1x mb-2">
        <div class="column">
            <div class="shop-sorting">
                <label for="sorting">@lang('corals-ecommerce-mimity::labels.template.shop.sort')</label>
                <select class="form-control custom-select" id="shop_sort" style="width: auto">
                    <option disabled="disabled"
                            selected>@lang('corals-ecommerce-mimity::labels.template.shop.select_option')</option>
                    @foreach($sortOptions as $value => $text)
                        <option value="{{ $value }}" {{ request()->get('sort') == $value?'selected':'' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>

                <span class="text-muted">@lang('corals-ecommerce-mimity::labels.template.shop.show')
                    &nbsp;</span>
                <span>{{trans('corals-ecommerce-mimity::labels.template.shop.page',['current'=>$products->currentPage(),'total' => $products->lastPage()])}}</span>
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
    <div class="row no-gutters gutters-2">
        @forelse($products as $product)
            @include('partials.product_grid_item',compact('product'))
        @empty
            <h4>@lang('corals-ecommerce-mimity::labels.template.shop.sorry_no_result')</h4>
        @endforelse
    </div>
    {{ $products->appends(request()->except('page'))->links('partials.paginator') }}

@endsection
@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#shop_sort").change(function (values, handle) {
                $("#filterSort").val($(this).val());
                $("#filterForm").submit();
            })
        });
    </script>
@endsection