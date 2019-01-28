<?php

namespace Corals\Modules\Messaging\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ParticipationPresenter extends FractalPresenter
{

    /**
     * @return ParticipationsTransformer
     */
    public function getTransformer()
    {
        return new ParticipationsTransformer();
    }
}