<?php

namespace Corals\Modules\Foo\Facades;

use Illuminate\Support\Facades\Facade;

class Foo extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Foo\Classes\Foo::class;
    }
}