<?php

namespace Corals\Modules\Announcement\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Announcement\database\migrations\AnnouncementTables;
use Corals\Modules\Announcement\database\seeds\AnnouncementDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        AnnouncementTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        $announcementDatabaseSeeder = new AnnouncementDatabaseSeeder();
        
        $announcementDatabaseSeeder->rollback();
    }
}
