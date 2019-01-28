<?php

namespace Corals\Modules\Ecommerce\Traits;

use Carbon\Carbon;
use Corals\Modules\Ecommerce\Classes\CartItem;


/**
 * Class CouponTrait.
 */
trait ShippingTrait
{

    public function hasShippableItems($cartItems)
    {

        foreach ($cartItems as $cartItem) {
            if ($cartItem->id->product->shipping['enabled']) {
                return true;
            }
        }
        return false;
    }

    public function getShippableItems($cartItems)
    {
        $shippable = [];
        foreach ($cartItems as $cartItem) {
            if ($cartItem->id->product->shipping['enabled']) {
                $shippable[] = $cartItem;
            }
        }
        return $shippable;
    }


}
