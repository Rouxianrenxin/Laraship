<?php

namespace Corals\Modules\Ecommerce\Classes\Shippings;

use Corals\Modules\Ecommerce\Contracts\ShippingContract;

/**
 * Class Fixed.
 */
class FlatRate implements ShippingContract
{


    public $rate;
    public $description;
    public $name;

    /**
     * Fixed constructor.
     *
     * @param $code
     * @param $value
     * @param array $options
     */
    public function __construct($options = [])
    {


    }

    public function providerName()
    {
        return "FlatRate";
    }

    /**
     * Fixed constructor.
     *
     * @param $shipping_role
     * @param $value
     * @param array $options
     */
    public function initialize($options = [])
    {
        $this->name = $options['name'] ?? '';
        $this->rate = $options['rate'] ?? '';
        $this->description = $options['description'] ?? '';
    }

    /**
     * Gets the shipping Rates.
     *
     * @param $throwErrors boolean this allows us to capture errors in our code if we wish,
     * that way we can spit out why the coupon has failed
     *
     * @return array
     */
    public function getAvailableShipping($to_address, $shippable_items, $user = null)
    {

        $available_rates[$this->providerName() . '|' . $this->name] = [
            'provider' => $this->name,
            'service' => '',
            'currency' => \Payments::admin_currency_code(),
            'amount' => $this->rate,
            'estimated_days' => '',
            'description' => $this->description,

        ];

        return $available_rates;

    }


    public function createShippingTransaction($shipping_reference)
    {

        $shipping = [];

        $shipping['status'] = 'pending';
        $shipping['label_url'] = '';
        $shipping['tracking_number'] = '';

        return $shipping;
    }


    public function track($order)
    {
        try {
            $tracking_status = [];
            return $tracking_status;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
