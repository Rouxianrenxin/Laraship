<?php

namespace Corals\Modules\Payment\Facades;

use Illuminate\Support\Facades\Facade;

class Payments extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Payment\Classes\Payments::class;
    }
}