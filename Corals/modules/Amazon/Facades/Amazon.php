<?php

namespace Corals\Modules\Amazon\Facades;

use Illuminate\Support\Facades\Facade;

class Amazon extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Amazon\Classes\Amazon::class;
    }
}