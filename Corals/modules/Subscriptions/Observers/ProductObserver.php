<?php

namespace Corals\Modules\Subscriptions\Observers;

use Corals\Modules\Subscriptions\Models\Product;

class ProductObserver
{

    /**
     * @param Product $product
     */
    public function created(Product $product)
    {
    }
}