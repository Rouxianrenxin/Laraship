<?php

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class PagePresenter extends FractalPresenter
{

    /**
     * @return PageTransformer
     */
    public function getTransformer()
    {
        return new PageTransformer();
    }
}