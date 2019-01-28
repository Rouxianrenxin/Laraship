<?php

namespace Corals\Modules\Subscriptions\Facades;

use Illuminate\Support\Facades\Facade;

class Products extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Subscriptions\Classes\Products::class;
    }
}