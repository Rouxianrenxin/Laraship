<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class SubscriberPresenter extends FractalPresenter
{

    /**
     * @return SubscriberTransformer
     */
    public function getTransformer()
    {
        return new SubscriberTransformer();
    }
}