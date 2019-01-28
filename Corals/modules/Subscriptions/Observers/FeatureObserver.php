<?php

namespace Corals\Modules\Subscriptions\Observers;

use Corals\Modules\Subscriptions\Models\Feature;

class FeatureObserver
{

    /**
     * @param Feature $feature
     */
    public function created(Feature $feature)
    {
    }
}