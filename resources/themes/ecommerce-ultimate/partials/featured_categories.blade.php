@php $categories = \Shop::getFeaturedCategories(); @endphp

@if(!$categories->isEmpty())
    <!-- Top Categories-->
    <section class="container padding-top-3x padding-bottom-2x">
        <div class="text-center">
            @php \Actions::do_action('pre_display_ecommerce_featured_categories') @endphp
        </div>
        <h3 class="text-center mb-30">@lang('corals-ecommerce-ultimate::labels.partial.featured_categories')</h3>
        @php $j=0; @endphp
        @foreach($categories as $category)
            @if($j == 0)
                <div class="row">
                    @endif
                    <div class="col-lg-3 col-sm-6">
                        <div class="card border-0 mb-30">
                            <div class="card-body d-table w-100">
                                <div class="d-table-cell align-middle"
                                     href="{{ url('shop?category='.$category->slug) }}">
                                    <img class="d-block w-100" src="{{ $category->thumbnail }}" alt="Category">
                                </div>
                                <div class="d-table-cell align-middle pl-2">
                                    <h3 class="h6 text-thin">
                                        <strong>@lang('Ecommerce::attributes.product.starts_at')</strong>
                                    </h3>
                                    <h4 class="h6 d-table w-100 text-thin">
                                        <span class="d-table-cell align-bottom h1 text-medium">{{ \Payments::currency($category->starting_from_price) }}</span>
                                    </h4>
                                    <a class="text-decoration-none"
                                       href="{{ url('shop?category='.$category->slug) }}">{{ $category->name }}
                                        <i class="icon-chevron-right d-inline-block align-middle text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (++$j == 4)
                </div>
                @php $j = 0; @endphp
                @endif
                @endforeach

                @if($j != 0)</div>@endif
            <div class="row">
                <div class="col text-center">
                    <a class="btn btn-outline-secondary margin-top-none" href="{{ url('shop') }}">
                        @lang('corals-ecommerce-ultimate::labels.partial.all_categories')
                    </a>
                </div>
            </div>
    </section>
@endif