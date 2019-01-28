<?php

namespace Corals\Modules\Announcement\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Announcement\database\migrations\AnnouncementTables;
use Corals\Modules\Announcement\database\seeds\AnnouncementDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';
    
    protected $migrations = [
        AnnouncementTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $announcementDatabaseSeeder = new AnnouncementDatabaseSeeder();

        $announcementDatabaseSeeder->run();
    }
}
