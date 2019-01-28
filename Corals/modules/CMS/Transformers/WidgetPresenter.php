<?php

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class WidgetPresenter extends FractalPresenter
{

    /**
     * @return WidgetTransformer
     */
    public function getTransformer()
    {
        return new WidgetTransformer();
    }
}