<?php

namespace Corals\Modules\Advert\Observers;

use Corals\Modules\Advert\Models\Campaign;

class CampaignObserver
{

    /**
     * @param Campaign $campaign
     */
    public function created(Campaign $campaign)
    {
    }
}