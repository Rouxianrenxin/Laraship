<a class="wishlist-icon" data-toggle="tooltip"
   title="@lang('corals-classified-master::labels.wishlist.title')" data-color="blue" data-style="zoom-in"
   href="{{ url('classified/wishlist/'.$product->hashed_id) }}"
   data-action="post" data-page_action="toggleWishListProduct"
   data-wishlist_product_hashed_id="{{$product->hashed_id}}">
    <i data-wislist_class="{{$product->hashed_id}}"
       class="lni-heart{{ $wishlist ? '-filled' : '' }}"></i>
</a>