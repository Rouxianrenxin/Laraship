<?php

namespace Corals\Modules\CMS\Observers;

use Corals\Modules\CMS\Models\Category;

class CategoryObserver
{

    /**
     * @param Category $category
     */
    public function created(Category $category)
    {
    }
}