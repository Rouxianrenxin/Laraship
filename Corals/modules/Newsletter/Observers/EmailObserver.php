<?php

namespace Corals\Modules\Newsletter\Observers;


use Corals\Modules\Newsletter\Models\Email;

class EmailObserver
{

    /**
     * @param Email $email
     */
    public function created(Email $email)
    {
    }

    /**
     * @param Email $email
     */
    public function deleting(Email $email)
    {
        $email->emailLoggers()->each(function ($emailLogger){
           $emailLogger->delete();
        });
    }

}