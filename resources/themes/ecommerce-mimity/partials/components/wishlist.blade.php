<a class="wishlist {{ !is_null($wishlist) ? 'active' : '' }}" data-toggle="tooltip"
   title="@lang('Ecommerce::module.wishlist.title')" data-style="zoom-in" data-color="red"
   href="{{ url('e-commerce/wishlist/'.$product->hashed_id) }}"
   data-action="post" data-page_action="toggleWishListProduct"
   data-wishlist_product_hashed_id="{{$product->hashed_id}}">
    <i class="fa fa-heart"></i>
</a>


