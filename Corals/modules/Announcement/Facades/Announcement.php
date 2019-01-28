<?php

namespace Corals\Modules\Announcement\Facades;

use Illuminate\Support\Facades\Facade;

class Announcement extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Announcement\Classes\Announcement::class;
    }
}