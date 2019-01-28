<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class EmailPresenter extends FractalPresenter
{

    /**
     * @return EmailTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EmailTransformer();
    }
}