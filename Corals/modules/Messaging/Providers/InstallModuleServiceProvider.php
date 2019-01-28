<?php

namespace Corals\Modules\Messaging\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Messaging\database\migrations\MessagingTables;
use Corals\Modules\Messaging\database\seeds\MessagingDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';
    
    protected $migrations = [
        MessagingTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $messagingDatabaseSeeder = new MessagingDatabaseSeeder();

        $messagingDatabaseSeeder->run();
    }
}
