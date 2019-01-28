<?php

namespace Corals\Modules\Ecommerce\Facades;

use Illuminate\Support\Facades\Facade;

class Ecommerce extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Ecommerce\Classes\Ecommerce::class;
    }
}