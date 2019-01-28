<?php

namespace Corals\Modules\Amazon\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class AmazonDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AmazonPermissionsDatabaseSeeder::class);
        $this->call(AmazonMenuDatabaseSeeder::class);
        $this->call(AmazonSettingsDatabaseSeeder::class);
        $this->call(AmazonCategoriesTableSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Amazon::%')->delete();

        Menu::where('key', 'amazon')
            ->orWhere('active_menu_url', 'like', 'amazons%')
            ->orWhere('url', 'like', 'amazons%')
            ->delete();

        Setting::where('category', 'Amazon')->delete();

        Media::whereIn('collection_name', ['amazon-media-collection'])->delete();
    }
}
