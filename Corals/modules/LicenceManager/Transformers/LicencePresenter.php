<?php

namespace Corals\Modules\LicenceManager\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class LicencePresenter extends FractalPresenter
{

    /**
     * @return LicenceTransformer
     */
    public function getTransformer()
    {
        return new LicenceTransformer();
    }
}