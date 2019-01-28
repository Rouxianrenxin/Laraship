<?php

namespace Corals\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class Menus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return new \Corals\Menu\Classes\Menus();
    }
}
