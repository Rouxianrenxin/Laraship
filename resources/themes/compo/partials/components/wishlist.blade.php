<a class="btn btn-sm btn-wishlist {{ $wishlist ? 'btn-warning' : 'btn-success' }}" data-toggle="tooltip"
   title="Whishlist" data-style="zoom-in" data-color="red"
   href="{{ url('e-commerce/wishlist/'.$product->hashed_id) }}"
   data-action="post" data-page_action="toggleWishListProduct"
   data-wishlist_product_hashed_id="{{$product->hashed_id}}"><i
            class="fa fa-heart-o"></i></a>


