<?php

namespace Corals\Modules\FormBuilder\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class FormSubmissionPresenter extends FractalPresenter
{

    /**
     * @return FormSubmissionTransformer
     */
    public function getTransformer()
    {
        return new FormSubmissionTransformer();
    }
}