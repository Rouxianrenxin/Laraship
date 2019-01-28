<div class="featured-box list-box">
    <figure>
        @if($product->condition=='new')
            <div class="product-condition-new bg-yellow">
                <a href="{{url('products?condition='.$product->condition).'#list-view' }}">New</a>
            </div>
        @endif
        @if(\Settings::get('classified_wishlist_enable',true))
            @include('partials.components.wishlist',['wishlist'=> $product->inWishList() ])
        @endif
        <div class="image-container d-flex justify-content-center align-items-center">
            <a href="{{url("products/".$product->slug)}}">
                <img src="{{ $product->image }}" class="img-fluid" alt="{{ $product->name }}"/>
            </a>
        </div>
    </figure>
    <div class="feature-content">
        <div class="product-category">
            @foreach($product->activeCategories as $category)
                <a href="{{url('products?category='.$category->slug)}}"><i
                            class="lni-folder"></i> {!! $category->name !!}</a>
            @endforeach
            @foreach($product->activeTags as $tag)
                <span><i class="lni-tag"></i> {!! $tag->name !!} </span>
            @endforeach
        </div>

        <h4><a href="{{url("products/".$product->slug)}}">{!! $product->present('name') !!}</a></h4>

        <p>{{ str_limit($product->present('caption')) }}</p>

        <span data-toggle="tooltip" data-placement="top"
              title="{{$product->present('created_at')}}">@lang('corals-classified-master::labels.partial.posted_since') {!! $product->created_at->diffForHumans() !!}</span>

        <ul class="address">
            <li>
                <a href="{{url('products?location='.$product->location->slug)}}"><i
                            class="lni-map-marker"></i>{!! $product->location->name !!}</a>
            </li>
            <li>
                <a href="{{url('products?user='.$product->user->hashed_id)}}"><i
                            class="lni-user"></i>{!! $product->user->full_name !!}</a>
            </li>
            @if(!empty($product->condition))
                <li>
                    <a href="{{url('products?condition='.$product->condition)}}"><i
                                class="lni-package"></i> {{ $product->present('condition') }}</a>
                </li>
            @endif
        </ul>
        <div class="listing-bottom">
            <h3 class="price float-left">{!! $product->present('price') !!}</h3>
            @if($product->verified)
                <a class="btn btn-verified float-right disabled"><i
                            class="lni-check-box"></i> @lang('corals-classified-master::labels.partial.verified')
                </a>
            @endif
        </div>
    </div>
</div>