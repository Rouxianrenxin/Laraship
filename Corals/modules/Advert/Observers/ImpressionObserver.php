<?php

namespace Corals\Modules\Advert\Observers;

use Corals\Modules\Advert\Models\Impression;

class ImpressionObserver
{

    /**
     * @param Impression $impression
     */
    public function created(Impression $impression)
    {
    }
}