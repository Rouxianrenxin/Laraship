<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class WebsitePresenter extends FractalPresenter
{

    /**
     * @return WebsiteTransformer
     */
    public function getTransformer()
    {
        return new WebsiteTransformer();
    }
}