<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class AdvertiserPresenter extends FractalPresenter
{

    /**
     * @return AdvertiserTransformer
     */
    public function getTransformer()
    {
        return new AdvertiserTransformer();
    }
}