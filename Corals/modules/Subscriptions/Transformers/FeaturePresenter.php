<?php

namespace Corals\Modules\Subscriptions\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class FeaturePresenter extends FractalPresenter
{

    /**
     * @return FeatureTransformer
     */
    public function getTransformer()
    {
        return new FeatureTransformer();
    }
}