<a
        class="btn btn-outline-secondary btn-sm btn-wishlist {{ !is_null($wishlist) ? 'active' : '' }}"
        data-toggle="tooltip"
        data-style="zoom-in"
        href="{{ url('e-commerce/wishlist/'.$product->hashed_id) }}"
        data-action="post" data-page_action="toggleWishListProduct"
        data-wishlist_product_hashed_id="{{$product->hashed_id}}">
    <i class="icon-heart"></i>
    &nbsp;@lang('corals-ecommerce-ultimate::labels.partial.component.like')
</a>