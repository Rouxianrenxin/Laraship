<?php

namespace Corals\Modules\Ecommerce\Providers;

use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Modules\Ecommerce\Observers\ProductObserver;
use Corals\Modules\Ecommerce\Observers\SKUObserver;
use Illuminate\Support\ServiceProvider;

class EcommerceObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        SKU::observe(SKUObserver::class);
    }
}