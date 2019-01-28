<?php

namespace Corals\Modules\FormBuilder\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class FormPresenter extends FractalPresenter
{

    /**
     * @return FormTransformer
     */
    public function getTransformer()
    {
        return new FormTransformer();
    }
}