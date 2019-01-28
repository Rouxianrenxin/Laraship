<?php

namespace Corals\Modules\Announcement\Observers;

use Corals\Modules\Announcement\Models\Announcement;

class AnnouncementObserver
{

    /**
     * @param Announcement $announcement
     */
    public function created(Announcement $announcement)
    {
    }
}