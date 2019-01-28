<?php

namespace Corals\Modules\Ecommerce\Contracts;

/**
 * Interface ShippingContract.
 */
interface ShippingContract
{
    /**
     * ShippingContract constructor.
     *
     */
    public function __construct();


    /**
     * ShippingContract initialize.
     *
     */
    public function initialize($options = []);

    /**
     * Gets the Available Shipping methods.
     *
     * @return string
     */
    public function getAvailableShipping($to_address, $shippable_items, $user);


    /**
     * create tshipping Transaction
     *
     * @return double
     */
    public function createShippingTransaction($shippingReference);

    /**
     * Get provider Name
     *
     * @return string
     */
    public function providerName();


}
