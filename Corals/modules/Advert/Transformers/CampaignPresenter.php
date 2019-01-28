<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class CampaignPresenter extends FractalPresenter
{

    /**
     * @return CampaignTransformer
     */
    public function getTransformer()
    {
        return new CampaignTransformer();
    }
}