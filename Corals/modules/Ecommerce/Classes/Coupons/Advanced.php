<?php

namespace Corals\Modules\Ecommerce\Classes\Coupons;

use Corals\Modules\Ecommerce\Contracts\CouponContract;
use Corals\Modules\Ecommerce\Classes\ShoppingCart;
use Corals\Modules\Ecommerce\Exceptions\CouponException;
use Corals\Modules\Ecommerce\Models\OrderItem;
use Corals\Modules\Ecommerce\Traits\CouponTrait;

/**
 * Class Advanced.
 */
class Advanced implements CouponContract
{
    use CouponTrait;

    public $code;
    public $settings;

    /**
     * Fixed constructor.
     *
     * @param $code
     * @param $value
     * @param array $options
     */
    public function __construct($code, $settings, $options = [])
    {
        $this->code = $code;
        $this->settings = $settings;

        $this->setOptions($options);
    }


    /**
     * check the discount valid.
     *
     * @param $throwErrors boolean this allows us to capture errors in our code if we wish,
     * that way we can spit out why the coupon has failed
     *
     * @return boolean
     */
    public function validate($throwErrors = false, $user = null)
    {
        $this->checkValidTimes($this->settings->start, $this->settings->expiry, $throwErrors);

        if ($this->settings->min_cart_total) {
            $this->checkMinAmount($this->settings->min_cart_total, $throwErrors);
        }

        $maxDiscount = null;


        if (!$user) {
            $user = user();
        }

        if ($this->settings->users->count() > 0) {
            if ($this->settings->users->contains($user->id)) {
                return true;
            } else {
                if ($throwErrors) {
                    throw new CouponException(trans('Ecommerce::exception.coupon.not_eligible_use_coupon'));
                } else {
                    return false;
                }
            }

        }
        if ($this->settings->uses > 0) {
            $usage = OrderItem::where('type', 'Discount')->where('sku_code', $this->code)->count();
            if ($usage >= $this->settings->uses) {
                if ($throwErrors) {
                    throw new CouponException(trans('Ecommerce::exception.coupon.code_reached_maximum'));
                } else {
                    return false;
                }
            }
        }

    }


    /**
     * Gets the discount amount.
     *
     * @param $throwErrors boolean this allows us to capture errors in our code if we wish,
     * that way we can spit out why the coupon has failed
     *
     * @return string
     */
    public function discount($throwErrors = false, $user = null)
    {
        $subTotal = app(ShoppingCart::SERVICE)->subTotal(false);


        $products_total_price = 0;
        $products_total_quantity = 0;
        $product_limited = false;
        if ($this->settings->products->count() > 0) {
            $product_limited = true;

            $cart_items = \ShoppingCart::getItems();
            foreach ($cart_items as $cart_item) {
                if ($this->settings->users->contains($cart_item->id->product->id)) {
                    $products_total_price += ($cart_item->qty * $cart_item->price);
                    $product_limited += $cart_item->qty;
                }
            }

        }
        $discount = 0;

        if ($this->settings->type == "percentage") {

            if ($product_limited) {
                $subTotal = $products_total_price;
            }
            $discount = $subTotal * ($this->settings->value / 100);

        } else if ($this->settings->type == "fixed") {

            $discount = $this->settings->value;

        }

        if ($this->settings->max_discount_value) {
            // Returns either the max discount or the discount applied based on what is passed through
            $discount = $this->maxDiscount($this->settings->max_discount_value, $discount, false);
        }


        return $discount;
    }

    /**
     * Displays the value in a money format.
     *
     * @param null $locale
     * @param null $internationalFormat
     *
     * @return string
     */
    public function displayValue($locale = null, $internationalFormat = null, $format = true)
    {
        if ($this->settings->type == "fixed") {
            return currency()->format($this->discount());
        } else {
            return ($this->settings->value * 100) . '%';
        }

    }
}
