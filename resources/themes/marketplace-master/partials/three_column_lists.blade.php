<section class="container padding-bottom-2x">
    <div class="row">
        @if(!($topSellersProducts = \Shop::getTopSellers())->isEmpty())
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-featured-products">
                    <h3 class="widget-title">@lang('corals-marketplace-master::labels.partial.top_sellers')</h3>
                    <!-- Entry-->
                    @foreach($topSellersProducts as $product)
                        <div class="entry">
                            <div class="entry-thumb"><a href="{{ url('shop/'.$product->slug) }}"><img
                                            src="{{ $product->image }}" alt="{{ $product->name }}"></a>
                            </div>
                            <div class="entry-content">
                                <h4 class="entry-title">
                                    <a href="{{ url('shop/'.$product->slug) }}">{{ $product->name }}</a>
                                </h4>
                                <span class="entry-meta">{!! $product->price !!}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if(!($newArrivalsProducts = \Shop::getNewArrivals())->isEmpty())
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-featured-products">
                    <h3 class="widget-title">@lang('corals-marketplace-master::labels.partial.new_arrivals')</h3>
                    <!-- Entry-->
                    @foreach($newArrivalsProducts as $product)
                        <div class="entry">
                            <div class="entry-thumb"><a href="{{ url('shop/'.$product->slug) }}"><img
                                            src="{{ $product->image }}" alt="{{ $product->name }}"></a>
                            </div>
                            <div class="entry-content">
                                <h4 class="entry-title">
                                    <a href="{{ url('shop/'.$product->slug) }}">{{ $product->name }}</a>
                                </h4>
                                <span class="entry-meta">{!! $product->price !!}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if(!($bestRatedProducts = \Shop::getBestRated())->isEmpty())
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-featured-products">
                    <h3 class="widget-title">@lang('corals-marketplace-master::labels.partial.best_rated')</h3>
                    <!-- Entry-->
                    @foreach($bestRatedProducts as $product)
                        <div class="entry">
                            <div class="entry-thumb"><a href="{{ url('shop/'.$product->slug) }}"><img
                                            src="{{ $product->image }}" alt="{{ $product->name }}"></a>
                            </div>
                            <div class="entry-content">
                                <h4 class="entry-title">
                                    <a href="{{ url('shop/'.$product->slug) }}">{{ $product->name }}</a>
                                </h4>
                                <span class="entry-meta">{!! $product->price !!}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>