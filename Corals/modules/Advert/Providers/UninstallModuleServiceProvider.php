<?php

namespace Corals\Modules\Advert\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Menu\Models\Menu;
use Corals\Modules\Advert\database\migrations\AdvertsTables;
use Corals\User\Models\Permission;
use Spatie\MediaLibrary\Media;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        AdvertsTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        Permission::where('name', 'like', 'Advert::%')->delete();
        Permission::where('name', 'Administrations::admin.advertiser')->delete();

        Menu::where('key', 'advert')
            ->orWhere('active_menu_url', 'like', 'advert%')
            ->orWhere('url', 'like', 'advert%')
            ->delete();

        Media::whereIn('collection_name', ['advert-banner-media'])->delete();
    }
}
