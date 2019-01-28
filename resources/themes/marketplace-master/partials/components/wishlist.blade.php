<a class="btn btn-outline-secondary btn-sm btn-wishlist {{ !is_null($wishlist) ? 'active' : '' }}" data-toggle="tooltip"
   title="@lang('Marketplace::module.wishlist.title')" data-style="zoom-in" data-color="red"
   href="{{ url('marketplace/wishlist/'.$product->hashed_id) }}"
   data-action="post" data-page_action="toggleWishListProduct"
   data-wishlist_product_hashed_id="{{$product->hashed_id}}"><i
            class="icon-heart"></i></a>


