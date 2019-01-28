@php $brands = \Shop::getFeaturedBrands(); @endphp
@if(!$brands->isEmpty())
    <h3 class="title mt-4">@lang('corals-ecommerce-mimity::labels.partial.popular_brands')</h3>
    <div class="content-slider">
        <div class="swiper-container brands-slider" id="brands-slider">
            <div class="swiper-wrapper">

                @foreach($brands as $brand)
                    @if($loop->first || ($loop->index + 1) % 6 == 1)
                        <div class="swiper-slide">
                            <div class="row no-gutters gutters-2">
                                @endif
                                <div class="col-6 col-sm-4 col-md-2 mb-2">
                                    <a href="{{ url('shop?brand[]='.$brand->slug) }}" class="card">
                                        <img src="{{ $brand->thumbnail }}" alt="{{ $brand->name }}"
                                             class="card-img-top"
                                             style="max-height: 25px">
                                    </a>
                                </div>

                                @if($loop->last || ($loop->index + 1)  % 6 == 0)
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
        <a href="#" role="button" class="carousel-control-prev" id="brands-slider-prev"><i
                    class="fa fa-angle-left fa-lg"></i></a>
        <a href="#" role="button" class="carousel-control-next" id="brands-slider-next"><i
                    class="fa fa-angle-right fa-lg"></i></a>

    </div>

@endif
