<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class TransactionPresenter extends FractalPresenter
{

    /**
     * @return WebhookCallTransformer
     */
    public function getTransformer()
    {
        return new WebhookCallTransformer();
    }
}