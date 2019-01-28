<?php

namespace Corals\Modules\Classified\Facades;

use Illuminate\Support\Facades\Facade;

class Classified extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Classified\Classes\Classified::class;
    }
}