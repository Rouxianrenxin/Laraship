<?php

namespace Corals\Modules\Slider\Facades;

use Illuminate\Support\Facades\Facade;

class Slider extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Slider\Classes\Slider::class;
    }
}