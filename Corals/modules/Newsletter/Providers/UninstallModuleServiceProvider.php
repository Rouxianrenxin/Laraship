<?php

namespace Corals\Modules\Newsletter\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Newsletter\database\migrations\NewsletterTables;
use Corals\Modules\Newsletter\database\seeds\NewsletterDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        NewsletterTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        $newsletterDatabaseSeeder = new NewsletterDatabaseSeeder();
        
        $newsletterDatabaseSeeder->rollback();
    }
}
