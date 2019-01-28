<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class EmailLoggerPresenter extends FractalPresenter
{

    /**
     * @return EmailLoggerTransformer
     */
    public function getTransformer()
    {
        return new EmailLoggerTransformer();
    }
}