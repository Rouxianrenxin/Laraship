<?php

namespace Corals\Modules\Ecommerce\Observers;

use Corals\Modules\Ecommerce\Models\SKU;

class SKUObserver
{

    /**
     * @param SKU $sku
     */
    public function created(SKU $sku)
    {
    }
}