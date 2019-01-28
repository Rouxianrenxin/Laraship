<?php

namespace Corals\Modules\Utility\Facades\Rating;

use Illuminate\Support\Facades\Facade;

class RatingManager extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\Classes\Rating\RatingManager::class;
    }
}