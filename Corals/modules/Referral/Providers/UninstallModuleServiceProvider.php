<?php

namespace Corals\Modules\Referral\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Menu\Models\Menu;
use Corals\Modules\Referral\database\migrations\ReferralTables;

use Corals\User\Models\Permission;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        ReferralTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        Permission::where('name', 'like', 'Referral::referral%')->delete();

        Menu::where('active_menu_url', 'like', 'referral%')->orWhere('url', 'like', 'referral/referral%')->delete();
    }
}
