<?php

namespace Corals\Modules\Subscriptions\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class PlanPresenter extends FractalPresenter
{

    /**
     * @return PlanTransformer
     */
    public function getTransformer()
    {
        return new PlanTransformer();
    }
}