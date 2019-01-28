<?php

namespace Corals\Modules\Utility\Facades\Category;

use Illuminate\Support\Facades\Facade;

class Category extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\Classes\Category\CategoryManager::class;
    }
}