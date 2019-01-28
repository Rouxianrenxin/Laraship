<?php

namespace Corals\Modules\Slider\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Menu\Models\Menu;
use Corals\Modules\Slider\database\migrations\SliderTables;
use Corals\User\Models\Permission;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        SliderTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        Permission::where('name', 'like', 'CMS::slider%')->delete();

        Menu::where('active_menu_url', 'like', 'slider%')->orWhere('url', 'like', 'slider/sliders%')->delete();
    }
}
