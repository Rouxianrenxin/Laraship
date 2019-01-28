<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 5/7/2018
 * Time: 7:19 PM
 */

namespace Corals\Modules\Newsletter\Facades;


use Illuminate\Support\Facades\Facade;

class Newsletter extends Facade
{

    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Newsletter\Classes\Newsletter::class;
    }
}