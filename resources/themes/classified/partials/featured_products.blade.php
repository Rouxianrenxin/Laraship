@if(!($products = \Classified::getFeaturedProducts(10))->isEmpty())
    <!-- Featured Listings Start -->
    <section class="featured-lis section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                    <h3 class="section-title">Featured Products</h3>
                    <div id="new-products" class="owl-carousel">
                        @foreach($products as $product)
                            <div class="item">
                                <div class="product-item">
                                    <div class="carousel-thumb">
                                        <div class="image-container d-flex justify-content-center align-items-center">
                                            <a href="{{url("products/".$product->slug)}}">
                                                <img src="{{$product->image}}" class="img-fluid"
                                                     alt="{{ $product->name }}"/>
                                            </a>
                                        </div>
                                        <div class="overlay">
                                        </div>
                                        @if($product->condition=='new')
                                            <div class="product-condition-new bg-yellow">
                                                <a href="{{url('products?condition='.$product->condition)}}">New</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-content">
                                        <h3 class="product-title">
                                            <a href="{{ url("products/".$product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <span class="price">{{ $product->present('price') }}</span>

                                        <div class="card-text d-flex flex-wrap justify-content-between">
                                            <div>
                                                <a href="{{ url('products?location='.$product->location->slug) }}">
                                                    <i class="lni-map-marker"></i> {!! $product->location->name !!}
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{url('products?user='.$product->user->hashed_id)}}"><i
                                                            class="lni-user"></i> {!! $product->user->full_name !!}</a>
                                            </div>
                                            @if(\Settings::get('classified_wishlist_enable',true))
                                                <div>
                                                    @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif