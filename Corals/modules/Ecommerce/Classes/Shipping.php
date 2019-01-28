<?php

namespace Corals\Modules\Ecommerce\Classes;

use Corals\Modules\Ecommerce\Models\Shipping as ShippingModel;
use Corals\Modules\Ecommerce\Traits\ShippingTrait;


class Shipping
{
    use ShippingTrait;


    public function getAvailableShippingMethods($shipping_address, $cart, $order_total)
    {
        $country = $shipping_address['country'];
        $shipping_roles = ShippingModel::where('country', $country)->orWhereNull('country')->orderBy('exclusive', 'DESC')->orderBy('priority', 'asc')->orderBy('name', 'asc')->get();
        if (!$shipping_roles) {
            return [];
        }
        $shippable_items = $this->getShippableItems($cart);

        $applied_methods = [];
        $available_rates = [];
        $continue_shipping_scan = true;
        foreach ($shipping_roles as $shipping_role) {
            try {
                if (!$continue_shipping_scan) {
                    continue;
                }
                if ($shipping_role->min_order_total) {
                    if ($order_total < $shipping_role->min_order_total) {
                        continue;
                    }
                }
                if (!$this->isShippingMethodSupported($shipping_role->shipping_method)) {
                    continue;
                }
                if (in_array($shipping_role->name, $applied_methods)) {
                    continue;
                }
                $shipping_method = \App::make('Corals\\Modules\\Ecommerce\\Classes\\Shippings\\' . $shipping_role->shipping_method);

                $shipping_method->initialize($shipping_role->toArray());
                $shipping_method_rates = $shipping_method->getAvailableShipping($shipping_address, $shippable_items);
                if ($shipping_role->exclusive && (count($shipping_method_rates) > 0)) {
                    $available_rates = $shipping_method_rates;
                    $continue_shipping_scan = false;

                } else {
                    $available_rates = array_merge($shipping_method_rates, $available_rates);
                }

                $applied_methods[] = $shipping_role->name;
            } catch (\Exception $exception) {

            }
        }
        return $available_rates;

    }


    public function getProviderName($selected_shipping)
    {
        list($shipping_method, $shipping_object) = explode('|', $selected_shipping);
        return $shipping_method;
    }

    public function track($order)
    {
        $provider = @$order['shipping']['shipping_provider'];
        if (!$provider) {
            return [];
        }
        $shipping_method = \App::make('Corals\\Modules\\Ecommerce\\Classes\\Shippings\\' . $provider);
        $shipping_method->initialize();
        return $shipping_method->track($order);

    }

    public function createShippingTransaction($selected_shipping)
    {
        list($shipping_method, $shipping_object) = explode('|', $selected_shipping);
        $shipping_method = \App::make('Corals\\Modules\\Ecommerce\\Classes\\Shippings\\' . $shipping_method);
        $shipping_method->initialize();

        $result = $shipping_method->createShippingTransaction($shipping_object);
        return $result;
    }

    public function getShippingMethods()
    {
        $supported_shipping_methods = \Settings::get('supported_shipping_methods', []);
        return $supported_shipping_methods;
    }

    public function setShippingMethods($supported_shipping_methods)
    {
        \Settings::set('supported_shipping_methods', json_encode($supported_shipping_methods));

    }


    public function isShippingMethodSupported($shipping_methods)
    {
        return array_key_exists($shipping_methods, $this->getShippingMethods());
    }
}