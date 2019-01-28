<?php

namespace Corals\Modules\Referral\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ReferralLinkPresenter extends FractalPresenter
{

    /**
     * @return ReferralLinkTransformer
     */
    public function getTransformer()
    {
        return new ReferralLinkTransformer();
    }
}