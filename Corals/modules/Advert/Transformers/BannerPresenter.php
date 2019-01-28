<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class BannerPresenter extends FractalPresenter
{

    /**
     * @return BannerTransformer
     */
    public function getTransformer()
    {
        return new BannerTransformer();
    }
}