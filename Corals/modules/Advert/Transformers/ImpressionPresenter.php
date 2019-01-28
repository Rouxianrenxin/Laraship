<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ImpressionPresenter extends FractalPresenter
{

    /**
     * @return ImpressionTransformer
     */
    public function getTransformer()
    {
        return new ImpressionTransformer();
    }
}