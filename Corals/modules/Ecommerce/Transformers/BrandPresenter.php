<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class BrandPresenter extends FractalPresenter
{

    /**
     * @return BrandTransformer
     */
    public function getTransformer()
    {
        return new BrandTransformer();
    }
}