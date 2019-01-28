<?php

namespace Corals\Modules\Subscriptions\Observers;

use Corals\Modules\Subscriptions\Models\Plan;

class PlanObserver
{

    /**
     * @param Plan $plan
     */
    public function created(Plan $plan)
    {
    }
}