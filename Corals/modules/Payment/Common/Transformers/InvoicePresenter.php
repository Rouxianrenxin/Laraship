<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class InvoicePresenter extends FractalPresenter
{

    /**
     * @return InvoiceTransformer
     */
    public function getTransformer()
    {
        return new InvoiceTransformer();
    }
}