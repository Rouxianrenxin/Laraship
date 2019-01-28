<?php

namespace Corals\Modules\CMS\Observers;

use Corals\Modules\CMS\Models\Faq;

class FaqObserver
{
    /**
     * @param Faq $faq
     */
    public function created(Faq $faq)
    {
    }
}