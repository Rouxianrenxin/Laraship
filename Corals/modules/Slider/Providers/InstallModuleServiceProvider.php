<?php

namespace Corals\Modules\Slider\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Slider\database\migrations\SliderTables;
use Corals\Modules\Slider\database\seeds\SliderDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        SliderTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $sliderDatabaseSeeder = new SliderDatabaseSeeder();

        $sliderDatabaseSeeder->run();
    }
}
