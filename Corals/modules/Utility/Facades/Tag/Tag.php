<?php

namespace Corals\Modules\Utility\Facades\Tag;

use Illuminate\Support\Facades\Facade;

class Tag extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\Classes\Tag\TagManager::class;
    }
}