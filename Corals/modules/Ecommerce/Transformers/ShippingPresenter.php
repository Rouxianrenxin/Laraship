<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ShippingPresenter extends FractalPresenter
{

    /**
     * @return ShippingTransformer
     */
    public function getTransformer()
    {
        return new ShippingTransformer();
    }
}