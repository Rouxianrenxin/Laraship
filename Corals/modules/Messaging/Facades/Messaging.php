<?php

namespace Corals\Modules\Messaging\Facades;

use Illuminate\Support\Facades\Facade;

class Messaging extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Messaging\Classes\Messaging::class;
    }
}