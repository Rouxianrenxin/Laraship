@php $categories = \Shop::getFeaturedCategories();  @endphp

@if(!$categories->isEmpty())
    <h3 class="title mt-4">@lang('corals-ecommerce-mimity::labels.partial.featured_categories')</h3>

    <div class="content-slider">
        <div class="swiper-container categories-slider" id="categories-slider">
            @php
                $color_classes = ['pink','primary','purpule','info','success','warning','danger'];

            @endphp
            <div class="swiper-wrapper">
                @foreach($categories as $category)

                    @if($loop->first || ($loop->index + 1) % 6 == 1)
                        <div class="swiper-slide">
                            <div class="row no-gutters gutters-2">
                                @endif
                                <div class="col-6 col-md-3 mb-1">
                                    <a href="{{ url('shop?category='.$category->slug) }}" class="card">
                                        <img src="{{ $category->thumbnail }}" alt="" class="card-img-top">
                                        <div class="card-img-overlay card-img-overlay-bottom p-2 {{ $color_classes[$loop->index % 7] }}">
                                            <h5>{{ $category->name }}</h5>
                                        </div>
                                    </a>

                                </div>
                                @if($loop->last || ($loop->index + 1)  % 6 == 0)
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
        <a href="#" role="button" class="carousel-control-prev" id="categories-slider-prev"><i
                    class="fa fa-angle-left fa-lg"></i></a>
        <a href="#" role="button" class="carousel-control-next" id="categories-slider-next"><i
                    class="fa fa-angle-right fa-lg"></i></a>

    </div>
@endif
