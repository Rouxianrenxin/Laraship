<?php

namespace Corals\Modules\Ecommerce\Classes\Coupons;

use Corals\Modules\Ecommerce\Contracts\CouponContract;
use Corals\Modules\Ecommerce\Classes\ShoppingCart;
use Corals\Modules\Ecommerce\Traits\CouponTrait;

/**
 * Class Fixed.
 */
class Fixed implements CouponContract
{
    use CouponTrait;

    public $code;
    public $value;

    /**
     * Fixed constructor.
     *
     * @param $code
     * @param $value
     * @param array $options
     */
    public function __construct($code, $value, $options = [])
    {
        $this->code = $code;
        $this->value = $value;

        $this->setOptions($options);
    }

    /**
     * Gets the discount amount.
     *
     * @param $throwErrors boolean this allows us to capture errors in our code if we wish,
     * that way we can spit out why the coupon has failed
     *
     * @return string
     */
    public function discount($throwErrors = false)
    {
        $subTotal = app(ShoppingCart::SERVICE)->subTotal(false);
        $total = $subTotal - $this->value;

        if (config('shoppingcart.discountOnFees', false)) {
            $total = $subTotal + app(ShoppingCart::SERVICE)->feeTotals(false) - $this->value;
        }

        if ($total < 0) {
            return $subTotal;
        }

        return $this->value;
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
        return ShoppingCart::formatMoney(
            $this->discount(),
            $locale,
            $internationalFormat,
            $format
        );
    }
}
