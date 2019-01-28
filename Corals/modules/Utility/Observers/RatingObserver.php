<?php

namespace Corals\Modules\Utility\Observers;

use Corals\Modules\Utility\Models\Rating\Rating;

class RatingObserver
{

    /**
     * @param Rating $rating
     */
    public function created(Rating $rating)
    {
    }
}