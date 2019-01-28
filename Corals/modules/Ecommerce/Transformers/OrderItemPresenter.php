<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class OrderItemPresenter extends FractalPresenter
{

    /**
     * @return OrderItemTransformer
     */
    public function getTransformer()
    {
        return new OrderItemTransformer();
    }
}