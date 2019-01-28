<?php

namespace Corals\Modules\Ecommerce\Classes;

/**
 * Class Cart.
 */
class Cart
{
    public $tax;
    public $fees = [];
    public $items;
    public $locale;
    public $instance;
    public $coupons = [];
    public $attributes = [];
    public $multipleCoupons;
    public $internationalFormat;

    /**
     * Cart constructor.
     *
     * @param string $instance
     */
    public function __construct($instance = 'default')
    {
        $this->instance = $instance;
        $this->tax = config('shoppingcart.tax');
        $this->locale = config('shoppingcart.locale');
        $this->multipleCoupons = config('shoppingcart.multiple_coupons');
        $this->internationalFormat = config('shoppingcart.international_format');
    }
}
