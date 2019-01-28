<?php

namespace Corals\Modules\Utility\Transformers\Wishlist;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Utility\Models\Wishlist\Wishlist;

class WishlistTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('utility.models.wishlist.resource_url');

        parent::__construct();
    }

    /**
     * @param Wishlist $wishlist
     * @return array
     * @throws \Throwable
     */
    public function transform(Wishlist $wishlist)
    {
        $actions = ['edit' => ''];

        return [
            'object' => '<a href="' . $wishlist->wishlistable->getShowURL() . '" target="_blank">' . $wishlist->wishlistable->getIdentifier() . '</a>',
            'id' => $wishlist->id,
            'user_id' => $wishlist->user->full_name,
            'created_at' => format_date($wishlist->created_at),
            'action' => $this->actions($wishlist, $actions)
        ];
    }
}