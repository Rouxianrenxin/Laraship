<?php

namespace Corals\Modules\LicenceManager\Facades;

use Illuminate\Support\Facades\Facade;

class LicenceManager extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\LicenceManager\Classes\LicenceManager::class;
    }
}