<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ZonePresenter extends FractalPresenter
{

    /**
     * @return ZoneTransformer
     */
    public function getTransformer()
    {
        return new ZoneTransformer();
    }
}