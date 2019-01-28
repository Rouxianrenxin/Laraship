<?php

namespace Corals\Modules\Utility\Facades\Address;

use Illuminate\Support\Facades\Facade;

class Address extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\Classes\Address\Address::class;
    }
}