<a
        class="save-btn {{ $wishlist ? '' : 'gray' }}"
        data-toggle="tooltip"
        data-style="zoom-in"
        href="{{ url('directory/wishlist/'.$listing->hashed_id) }}"
        data-action="post" data-page_action="toggleWishListListing"
        data-wishlist_product_hashed_id="{{$listing->hashed_id}}"
                data-wishlist_class="{{$listing->hashed_id}}">
    <i class="fa fa-heart"></i>
    &nbsp;@lang('corals-directory-basic::labels.partial.component.save_listing')
</a>