<?php

namespace Corals\Modules\Ecommerce\Observers;

use Corals\Modules\Ecommerce\Models\Product;

class ProductObserver
{

    /**
     * @param Product $product
     */
    public function created(Product $product)
    {
    }
}