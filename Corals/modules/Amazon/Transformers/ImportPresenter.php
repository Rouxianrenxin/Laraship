<?php

namespace Corals\Modules\Amazon\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ImportPresenter extends FractalPresenter
{

    /**
     * @return ImportTransformer
     */
    public function getTransformer()
    {
        return new ImportTransformer();
    }
}