<?php

namespace Corals\Modules\Ecommerce\Facades;

use Illuminate\Support\Facades\Facade;

class Shop extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Ecommerce\Classes\Shop::class;
    }
}