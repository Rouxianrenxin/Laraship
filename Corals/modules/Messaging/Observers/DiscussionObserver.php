<?php

namespace Corals\Modules\Messaging\Observers;

use Corals\Modules\Messaging\Models\Discussion;

class DiscussionObserver
{

    /**
     * @param Discussion $discussion
     */
    public function created(Discussion $discussion)
    {
    }
}