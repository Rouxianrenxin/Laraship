<?php

namespace Corals\Modules\CMS\Facades;

use Illuminate\Support\Facades\Facade;

class CMS extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\CMS\Classes\CMS::class;
    }
}