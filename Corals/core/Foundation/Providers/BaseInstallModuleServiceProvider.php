<?php

namespace Corals\Foundation\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class BaseInstallModuleServiceProvider extends ServiceProvider
{
    protected $migrations = [];
    protected $module_public_path = '';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
            $this->installPublicAssets();
            \Cache::flush();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function booted()
    {
    }

    protected function createSchema()
    {
        foreach ($this->migrations as $migration) {
            $migrationObject = new $migration();
            $migrationObject->up();
        }
    }

    protected function installPublicAssets()
    {
        $filesystem = new Filesystem();

        $modulePublicPath = $this->module_public_path;

        if (!empty($modulePublicPath) && $filesystem->exists($modulePublicPath)) {
            $filesystem->copyDirectory($modulePublicPath, public_path('/'));
        }
    }
}
