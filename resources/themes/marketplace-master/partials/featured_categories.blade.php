@php $categories = \Shop::getFeaturedCategories(); @endphp

@if(!$categories->isEmpty())
    <!-- Top Categories-->
    <section class="container padding-top-3x">
        <div class="text-center">
            @php \Actions::do_action('pre_display_marketplace_featured_categories') @endphp

        </div>


        <h3 class="text-center mb-30">@lang('corals-marketplace-master::labels.partial.featured_categories')</h3>
        @php $j=0; @endphp
        @foreach($categories as $category)
            @if($j == 0)
                <div class="row">
                    @endif
                    <div class="col-md-4 col-sm-6">
                        <div class="card mb-30">
                            <a class="card-img-tiles" href="{{ url('shop?category='.$category->slug) }}">
                                <div class="inner">
                                    <div class="main-img">
                                        <img src="{{ $category->thumbnail }}" alt="Category" class="mx-auto"
                                             style="max-height: 150px;width: auto;">
                                    </div>
                                </div>
                            </a>
                            <div class="card-body text-center">
                                <h4 class="card-title">
                                    <a href="{{ url('shop?category='.$category->slug) }}">{{ $category->name }}</a>
                                </h4>
                                <p class="text-muted">@lang('Marketplace::attributes.product.starts_at') {{ \Payments::currency($category->starting_from_price) }}</p>
                                <a class="btn btn-outline-primary btn-sm"
                                   href="{{ url('shop?category='.$category->slug) }}">@lang('corals-marketplace-master::labels.partial.view_products')
                                </a>
                            </div>
                        </div>
                    </div>
                    @if (++$j == 3)
                </div>
                @php $j = 0; @endphp
                @endif
                @endforeach

                @if($j != 0)</div>@endif
            <div class="row">
                <div class="col text-center">
                    <a class="btn btn-outline-secondary margin-top-none" href="{{ url('shop') }}">
                        @lang('corals-marketplace-master::labels.partial.all_categories')
                    </a>
                </div>
            </div>
    </section>
@endif