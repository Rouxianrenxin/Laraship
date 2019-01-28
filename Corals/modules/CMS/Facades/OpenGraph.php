<?php

namespace Corals\Modules\CMS\Facades;

use Illuminate\Support\Facades\Facade;

class OpenGraph extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'seotools.opengraph';
    }
}
