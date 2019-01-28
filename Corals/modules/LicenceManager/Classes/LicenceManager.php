<?php

namespace Corals\Modules\LicenceManager\Classes;

class LicenceManager
{
    /**
     * LicenceManager constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $gateway
     * @param $order
     * @param $user
     * @param $checkoutDetails
     * @param $invoice
     */
    public function post_ecommerce_pay_order($gateway, $order, $user, $checkoutDetails, $invoice)
    {
        try {
            $items = $order->items()->where('type', 'Product')->get();

            foreach ($items as $item) {
                $quantity = $item->quantity;

                $product = $item->sku->product;

                if (!$product->hasProperty('has_licence')) {
                    continue;
                }

                foreach (range(1, $quantity) as $index) {
                    $licence = $product->licences()->status('free')->first();

                    if ($licence) {
                        $licence->update([
                            'parent_type' => get_class($order),
                            'parent_id' => $order->id,
                            'status' => 'reserved'
                        ]);
                    } else {
                        //TODO:: handle if no licence found
                    }
                }
            }
        } catch (\Exception $exception) {
            log_exception($exception);
        }
    }

    /**
     * @param $sku
     * @param $inventory
     * @return bool
     */
    public function sku_pre_stock_status($inventory, $sku)
    {
        $product = $sku->product;

        if (!$product->hasProperty('has_licence')) {
            return $inventory;
        }

        return $sku->product->licences()->status('free')->count();
    }

    /**
     * @param $order
     * @throws \Throwable
     */
    public function ecommerce_order_post_details($order)
    {
        $licences = $order->licenceList->get();

        if (!$licences->isEmpty()) {
            echo view('LicenceManager::licences.partials.order_details', compact('order', 'licences'))->render();
        }
    }

    /**
     * @param $product
     * @throws \Throwable
     */
    public function ecommerce_product_form_post_fields($product)
    {
        echo view('LicenceManager::licences.partials.product_fields', compact('product'))->render();
    }
}