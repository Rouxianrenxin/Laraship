<?php

namespace Corals\Modules\Utility\Classes;

class Utility
{
    protected $utilityModules = [];

    /**
     * Utility constructor.
     */
    function __construct()
    {
    }

    public function addToUtilityModules($module)
    {
        array_push($this->utilityModules, $module);
    }

    public function getUtilityModules()
    {
        return array_combine($this->utilityModules, $this->utilityModules);
    }
}