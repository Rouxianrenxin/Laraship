<?php

namespace Corals\Modules\Newsletter\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Newsletter\database\migrations\NewsletterTables;
use Corals\Modules\Newsletter\database\seeds\NewsletterDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';
    
    protected $migrations = [
        NewsletterTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $newsletterDatabaseSeeder = new NewsletterDatabaseSeeder();

        $newsletterDatabaseSeeder->run();
    }
}
