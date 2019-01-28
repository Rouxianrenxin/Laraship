<?php

namespace Corals\Modules\Subscriptions\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ProductPresenter extends FractalPresenter
{

    /**
     * @return PlanTransformer
     */
    public function getTransformer()
    {
        return new ProductTransformer();
    }
}