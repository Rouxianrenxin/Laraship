<?php

namespace Corals\Modules\Announcement\Listeners;


use Corals\Modules\Announcement\Facades\Announcement;
use Illuminate\Auth\Events\Login;

class ShowOnLoginAnnouncements
{
    public function __construct()
    {
    }

    /**
     * @param Login $login
     */
    public function handle(Login $login)
    {
        $announcements = Announcement::unreadAnnouncements($login->user, false, null, ['show_immediately' => true]);

        $show_announcements = [];

        foreach ($announcements as $announcement) {
            array_push($show_announcements, [
                'title' => $announcement->title,
                'url' => $announcement->getShowURL()]);
        }

        \JavaScript::put([
            'show_announcements' => $show_announcements
        ]);
    }
}