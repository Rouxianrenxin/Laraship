<?php

namespace Corals\Modules\Utility\Traits\Wishlist;

use Corals\Modules\Utility\Models\Wishlist\Wishlist;
use Illuminate\Database\Eloquent\Model;

trait Wishlistable
{
    public static function bootWishlistable()
    {
        static::deleted(function (Model $deletedModel) {

            $deletedModel->wishlists()->delete();

        });
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }

    /**
     * @param null $user
     * @return null
     */
    public function inWishlist($user = null)
    {
        if (is_null($user)) {
            $user = user();
        }

        if ($user) {
            return $this->wishlists()->where('user_id', $user->id)->first();
        } else {
            return null;
        }
    }

    public function wishlistsCount()
    {
        return $this->wishlists()->count();
    }
}