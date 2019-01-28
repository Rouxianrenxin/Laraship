<?php

namespace Corals\Modules\CMS\Observers;

use Corals\Modules\CMS\Models\Page;

class PageObserver
{

    /**
     * @param Page $page
     */
    public function created(Page $page)
    {
    }
}