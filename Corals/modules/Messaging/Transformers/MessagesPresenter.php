<?php

namespace Corals\Modules\Messaging\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class MessagesPresenter extends FractalPresenter
{
    /**
     * @return MessageTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MessageTransformer();
    }
}