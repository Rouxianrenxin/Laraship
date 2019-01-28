<?php

namespace Corals\Modules\Utility\Transformers\Rating;

use Corals\Foundation\Transformers\FractalPresenter;

class RatingPresenter extends FractalPresenter
{

    /**
     * @return RatingTransformer
     */
    public function getTransformer()
    {
        return new RatingTransformer();
    }
}