<?php

namespace Corals\Modules\Referral\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ReferralRelationshipPresenter extends FractalPresenter
{

    /**
     * @return ReferralRelationshipTransformer
     */
    public function getTransformer()
    {
        return new ReferralRelationshipTransformer();
    }
}