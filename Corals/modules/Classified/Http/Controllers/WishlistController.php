<?php

namespace Corals\Modules\Classified\Http\Controllers;

use Corals\Modules\Classified\Models\Product;
use Corals\Modules\Utility\Classes\Wishlist\WishlistManager;
use Corals\Modules\Utility\Http\Controllers\Wishlist\WishlistBaseController;
use Corals\Settings\Facades\Settings;
use Illuminate\Http\Request;

class WishlistController extends WishlistBaseController
{
    protected function setCommonVariables()
    {
        $this->wishlistableClass = Product::class;
    }

    public function setTheme()
    {
        \Theme::set(\Settings::get('active_frontend_theme', config('themes.corals_frontend')));
    }

    public function myWishlist(Request $request)
    {
        $pageLimit = Settings::get('classified_appearance_page_limit', 15);

        $wishlistManager = new WishlistManager(new $this->wishlistableClass);

        $this->setViewSharedData([
            'title' => 'Classified::module.wishlist.title',
            'title_singular' => 'Classified::module.wishlist.title_singular'
        ]);

        $wishlists = $wishlistManager->getUserWishlist()->paginate($pageLimit);

        return view('views.myWishlists', compact('wishlists'));
    }
}