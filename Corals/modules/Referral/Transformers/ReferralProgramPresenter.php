<?php

namespace Corals\Modules\Referral\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ReferralProgramPresenter extends FractalPresenter
{

    /**
     * @return ReferralProgramTransformer
     */
    public function getTransformer()
    {
        return new ReferralProgramTransformer();
    }
}