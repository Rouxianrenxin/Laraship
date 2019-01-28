<?php

namespace Corals\Modules\Directory\Facades;

use Illuminate\Support\Facades\Facade;

class Directory extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Directory\Classes\Directory::class;
    }
}