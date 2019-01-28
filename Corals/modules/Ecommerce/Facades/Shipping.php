<?php

namespace Corals\Modules\Ecommerce\Facades;

use Illuminate\Support\Facades\Facade;

class Shipping extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Ecommerce\Classes\Shipping::class;
    }
}