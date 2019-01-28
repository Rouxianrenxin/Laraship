<div class="modal fade modal-filter" id="filterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="filterForm">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search"
                               placeholder="@lang('Ecommerce::labels.shop.search')"
                               value="{{request()->get('search')}}">
                        <input type="hidden" name="sort" id="filterSort" value=""/>
                    </div>
                    <hr>
                    <div class="form-group">
                        <ul>
                            @foreach(\Shop::getActiveCategories() as $category)
                                <li class="{{ $hasChildren = $category->hasChildren()?'has-children':'' }} parent-category">
                                    @if($hasChildren)
                                        <a href="#collapseExample" data-toggle="collapse">{{ $category->name }}</a>
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
                                        <ul class="collapse" id="collapseExample">
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
                    </div>
                    <hr>
                    @php
                        $min = \Shop::getSKUMinPrice()??0;
                        $max= \Shop::getSKUMaxPrice()??9999999;
                    @endphp
                    @if($min !== $max )
                        <div class="form-group">
                            <label class="mb-5">@lang('corals-ecommerce-mimity::labels.template.shop.price_range')</label>
                            <div id="price-range"></div>
                            <input name="price[min]" id="slider_min_price" type="hidden" value="{{ request()->input('price.min') ?? $min }}">
                            <input name="price[max]" id="slider_max_price" type="hidden" value="{{ request()->input('price.max') ?? $max }}">
                        </div>
                    @endif
                    <hr>
                    <div class="form-group text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-success"
                                    type="submit">@lang('corals-ecommerce-mimity::labels.template.shop.filter')</button>
                            <button type="button" class="btn btn-info" data-dismiss="modal" aria-label="Close">
                                @lang('corals-ecommerce-mimity::labels.template.shop.done')
                            </button>
                        </div>
                    </div>
                </form>
                @php \Actions::do_action('post_display_ecommerce_filter') @endphp
            </div>
        </div>
    </div>
</div>
@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')

    <script type="text/javascript">
        $(document).ready(function () {

            if ($('#price-range').length) {
                var priceRange = document.getElementById('price-range');
                var data_min =  {{$min}} ;
                var data_max =  {{$max}} ;
                noUiSlider.create(priceRange, {
                    start: [{{ request()->input('price.min') ?? $min}}, {{  request()->input('price.max') ?? $max }}],
                    connect: true,
                    tooltips: [true, true],
                    range: {
                        'min': data_min,
                        'max': data_max
                    }
                });
                priceRange.noUiSlider.on('change', function (values, handle) {
                    $("#slider_min_price").val(values[0]);
                    $("#slider_max_price").val(values[1]);
                });
            };
        });

    </script>
@endsection