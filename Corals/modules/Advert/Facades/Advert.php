<?php

namespace Corals\Modules\Advert\Facades;

use Illuminate\Support\Facades\Facade;

class Advert extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Advert\Classes\Advert::class;
    }
}