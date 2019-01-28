<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class MailListPresenter extends FractalPresenter
{

    /**
     * @return MailListTransformer
     */
    public function getTransformer()
    {
        return new MailListTransformer();
    }
}