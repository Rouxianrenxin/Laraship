<?php

namespace Corals\Modules\Slider\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class SlidePresenter extends FractalPresenter
{

    /**
     * @return SlideTransformer
     */
    public function getTransformer()
    {
        return new SlideTransformer();
    }
}