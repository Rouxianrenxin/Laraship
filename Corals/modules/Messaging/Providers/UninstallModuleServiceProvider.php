<?php

namespace Corals\Modules\Messaging\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Messaging\database\migrations\MessagingTables;
use Corals\Modules\Messaging\database\seeds\MessagingDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        MessagingTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        $messagingDatabaseSeeder = new MessagingDatabaseSeeder();
        
        $messagingDatabaseSeeder->rollback();
    }
}
