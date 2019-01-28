<a class="product-button btn-wishlist {{ !is_null($wishlist) ? 'active' : '' }} btn-cart ladaa " data-toggle="tooltip"
   data-style="zoom-in"
   href="{{ url('e-commerce/wishlist/'.$product->hashed_id) }}"
   data-action="post" data-page_action="toggleWishListProduct"
   data-wishlist_product_hashed_id="{{$product->hashed_id}}">
    <i class="icon-heart"></i>
    <span>@lang('corals-ecommerce-ultimate::labels.partial.component.like')</span>

</a>