<?php

namespace Corals\Modules\Newsletter\Observers;

use Corals\Modules\Newsletter\Models\MailList;

class MailListObserver
{

    /**
     * @param MailList $mailList
     */
    public function created(MailList $mailList)
    {
    }
}