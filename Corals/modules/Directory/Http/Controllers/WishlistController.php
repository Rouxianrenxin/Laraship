<?php

namespace Corals\Modules\Directory\Http\Controllers;


use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Utility\Http\Controllers\Wishlist\WishlistBaseController;
use Corals\Modules\Utility\Classes\Wishlist\WishlistManager;
use Corals\Settings\Facades\Settings;
use Illuminate\Http\Request;

class WishlistController extends WishlistBaseController
{


    protected function setCommonVariables()
    {
        $this->wishlistableClass = Listing::class;
    }

    public function setTheme()
    {
        \Theme::set(\Settings::get('active_frontend_theme', config('themes.corals_frontend')));
    }

    public function myWishlist(Request $request)
    {
        $pageLimit = Settings::get('directory_appearance_page_limit', 10);

        $wishlistManager = new WishlistManager(new $this->wishlistableClass);

        $this->setViewSharedData([
            'title' => 'Directory::module.wishlist.title',
            'title_singular' => 'Directory::module.wishlist.title_singular'
        ]);

        $wishlists = $wishlistManager->getUserWishlist()->paginate($pageLimit);

        return view('views.my_wishlists', compact('wishlists'));
    }

}