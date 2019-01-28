<?php

namespace Corals\Modules\Newsletter\Observers;

use Corals\Modules\Newsletter\Models\Subscriber;

class SubscriberObserver
{

    /**
     * @param Subscriber $subscriber
     */
    public function created(Subscriber $subscriber)
    {
    }
}