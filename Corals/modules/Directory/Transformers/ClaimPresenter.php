<?php

namespace Corals\Modules\Directory\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ClaimPresenter extends FractalPresenter
{

    /**
     * @return ClaimTransformer
     */
    public function getTransformer()
    {
        return new ClaimTransformer();
    }
}