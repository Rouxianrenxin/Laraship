<?php

namespace Corals\Modules\Slider\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class SliderPresenter extends FractalPresenter
{

    /**
     * @return SliderTransformer
     */
    public function getTransformer()
    {
        return new SliderTransformer();
    }
}