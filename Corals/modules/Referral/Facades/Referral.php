<?php

namespace Corals\Modules\Referral\Facades;

use Illuminate\Support\Facades\Facade;

class Referral extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Referral\Classes\Referral::class;
    }
}