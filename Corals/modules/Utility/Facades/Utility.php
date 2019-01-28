<?php

namespace Corals\Modules\Utility\Facades;

use Illuminate\Support\Facades\Facade;

class Utility extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\Classes\Utility::class;
    }
}