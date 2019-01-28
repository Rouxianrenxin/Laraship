<?php

namespace Corals\Modules\Directory\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ListingPresenter extends FractalPresenter
{

    /**
     * @return ListingTransformer
     */
    public function getTransformer()
    {
        return new ListingTransformer();
    }
}