<?php

namespace Corals\Modules\Messaging\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class DiscussionPresenter extends FractalPresenter
{

    /**
     * @return DiscussionTransformer
     */
    public function getTransformer()
    {
        return new DiscussionTransformer();
    }
}