<?php

namespace Corals\Modules\Classified\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ProductPresenter extends FractalPresenter
{

    /**
     * @return ProductTransformer
     */
    public function getTransformer()
    {
        return new ProductTransformer();
    }
}