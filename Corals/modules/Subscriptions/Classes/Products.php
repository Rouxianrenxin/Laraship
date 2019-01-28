<?php

namespace Corals\Modules\Subscriptions\Classes;

use Corals\Modules\Subscriptions\Models\Feature;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;

class Products
{
    /**
     * Products constructor.
     */
    function __construct()
    {
    }

    public function getPlansList()
    {
        $plans = Plan::join('products', 'products.id', 'plans.product_id')
            ->select(\DB::raw("concat(plans.name,' (',products.name,')') as plan_full_name"), 'plans.id')->pluck('plan_full_name', 'id');

        return $plans;
    }

    public function getFeaturesList()
    {
        $features = Feature::join('products', 'products.id', 'features.product_id')
            ->select(\DB::raw("concat(features.name,' (',products.name,')') as feature_full_name"), 'features.id')->pluck('feature_full_name', 'id');

        return $features;
    }

    public function getProductsList()
    {
        $products = Product::pluck('name', 'id');

        return $products;
    }
}