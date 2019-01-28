<?php

namespace Corals\Modules\Ecommerce\Classes\Shippings;

use Corals\Modules\Ecommerce\Contracts\ShippingContract;

/**
 * Class Fixed.
 */
class Shippo implements ShippingContract
{


    public $shipping_from;
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
        return "Shippo";
    }

    /**
     * Fixed constructor.
     *
     * @param $options
     * @param $value
     * @param array $options
     */
    public function initialize($options = [])
    {

        if (\Settings::get('ecommerce_shipping_shippo_sandbox_mode')) {
            \Shippo::setApiKey(\Settings::get('ecommerce_shipping_shippo_test_token'));

        } else {
            \Shippo::setApiKey(\Settings::get('ecommerce_shipping_shippo_live_token'));
        }
        $ecommerce_settings = \Settings::get('ecommerce*');
        $this->shipping_from = [
            'name' => $ecommerce_settings['ecommerce_company_owner'] ?? '',
            'company' => $ecommerce_settings['ecommerce_company_name'] ?? '',
            'street1' => $ecommerce_settings['ecommerce_company_street1'] ?? '',
            'city' => $ecommerce_settings['ecommerce_company_city'] ?? '',
            'state' => $ecommerce_settings['ecommerce_company_state'] ?? '',
            'zip' => $ecommerce_settings['ecommerce_company_zip'] ?? '',
            'country' => $ecommerce_settings['ecommerce_company_country'] ?? '',
            'phone' => $ecommerce_settings['ecommerce_company_phone'] ?? '',
            'email' => $ecommerce_settings['ecommerce_company_email'] ?? '',
        ];
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
        if (!$user) {
            $user = user();
        }
        $parcels = [];
        foreach ($shippable_items as $cart_item) {

            $parcels[] = [
                'length' => $cart_item->id->shipping['length'] ?? $cart_item->id->product->shipping['length'],
                'width' => $cart_item->id->shipping['width'] ?? $cart_item->id->product->shipping['width'],
                'height' => $cart_item->id->shipping['height'] ?? $cart_item->id->product->shipping['height'],
                'distance_unit' => \Settings::get('ecommerce_shipping_dimensions_unit', 'in'),
                'weight' => $cart_item->id->shipping['weight'] ?? $cart_item->id->product->shipping['weight'],
                'mass_unit' => \Settings::get('ecommerce_shipping_weight_unit', 'oz'),
                'quantity' => $cart_item->qty

            ];
        }
        $shipping_to = [
            'name' => $user->name,
            'street1' => $to_address['address_1'],
            'city' => $to_address['city'],
            'state' => $to_address['state'],
            'zip' => $to_address['zip'],
            'country' => $to_address['country'],


        ];
        $shipment = \Shippo_Shipment::create(
            array(
                'address_from' => $this->shipping_from,
                'address_to' => $shipping_to,
                'parcels' => $parcels,
                'async' => false,
            ));
//        \Logger($shipment);
        // Rates are stored in the `rates` array inside the shipment object
        $rates = $shipment['rates'];

        // You can now show those rates to the user in your UI.
        // Most likely you want to show some of the following fields:
        //  - provider (carrier name)
        //  - servicelevel_name
        //  - amount (price of label - you could add e.g. a 10% markup here)
        //  - days (transit time)
        // Don't forget to store the `object_id` of each Rate so that you can use it for the label purchase later.
        // The details on all of the fields in the returned object are here: https://goshippo.com/docs/reference#rates
        $available_rates = [];
        foreach ($rates as $rate) {
            $available_rates[$this->providerName() . '|' . $rate['object_id']] = [
                'provider' => $rate['provider'],
                'service' => $rate['servicelevel']['name'],
                'currency' => $rate['currency'],
                'amount' => $rate['amount'],
                'description' => '',
                'estimated_days' => $rate['estimated_days']
            ];


        }

        return $available_rates;

    }


    public function createShippingTransaction($shipping_reference)
    {
        $transaction = \Shippo_Transaction::create(array(
            'rate' => $shipping_reference,
            'async' => false,
        ));
        $shipping = [];
        // Print the shipping label from label_url
// Get the tracking number from tracking_number
        if ($transaction['status'] == 'SUCCESS') {
            $shipping['status'] = 'success';
            $shipping['label_url'] = $transaction['label_url'];
            $shipping['tracking_number'] = $transaction['tracking_number'];

        } else {
            $shipping['status'] = 'error';
            $shipping['error_message'] = '';

            foreach ($transaction['messages'] as $message) {
                $shipping['error_message'] .= $message . "<br>";
            }
        }
        return $shipping;
    }


    public function track($order)
    {


        try {

            $status_params = array(
                'id' => $order->shipping['tracking_number'],
                'carrier' => strtolower($order->shipping['selected_shipping']['provider']),
                //'carrier' =>'shippo',
                //'id'=>'SHIPPO_DELIVERED'
            );

            $status = \Shippo_Track::get_status($status_params);
            $status_history = $status['tracking_history'];
            $history = [];
            foreach ($status_history as $status_history_item) {
                $history[] = [
                    'status' => $status_history_item['status'],
                    'status_details' => $status_history_item['status_details'],
                    'status_date' => $status_history_item['status_date'],
                    'status_location' => [
                        'city' => $status_history_item['location']['city'],
                        'state' => $status_history_item['location']['state'],
                        'zip' => $status_history_item['location']['zip'],
                        'country' => $status_history_item['location']['country'],

                    ],
                ];
            }

            $tracking_status = ['status' => $status['tracking_status']['status'],
                'status_details' => $status['tracking_status']['status'],
                'status_date' => $status['tracking_status']['status_date'],
                'status_location' => [
                    'city' => $status['tracking_status']['location']['city'],
                    'state' => $status['tracking_status']['location']['state'],
                    'zip' => $status['tracking_status']['location']['zip'],
                    'country' => $status['tracking_status']['location']['country'],

                ],
                'history' => $history];

            return $tracking_status;
        } catch (\Shippo_Error $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
