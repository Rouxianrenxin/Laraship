<?php

namespace Corals\Modules\LicenceManager\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class LicenceManagerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LicenceManagerPermissionsDatabaseSeeder::class);
        $this->call(LicenceManagerMenuDatabaseSeeder::class);
        $this->call(LicenceManagerSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'LicenceManager::%')->delete();

        Menu::where('key', 'licence_manager')
            ->orWhere('active_menu_url', 'like', 'licence-manager%')
            ->orWhere('url', 'like', 'licence-manager%')
            ->delete();

        Setting::where('category', 'LicenceManager')->delete();

        Media::whereIn('collection_name', ['licence-manager-media-collection'])->delete();
    }
}
