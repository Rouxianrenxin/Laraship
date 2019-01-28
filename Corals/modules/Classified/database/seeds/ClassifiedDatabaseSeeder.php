<?php

namespace Corals\Modules\Classified\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class ClassifiedDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClassifiedPermissionsDatabaseSeeder::class);
        $this->call(ClassifiedMenuDatabaseSeeder::class);
        $this->call(ClassifiedSettingsDatabaseSeeder::class);
        $this->call(ClassifiedNotificationTemplatesSeeder::class);

    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Classified::%')->delete();
        Permission::where('name', 'Administrations::admin.classified')->delete();

        Menu::where('key', 'classified')
            ->orWhere('active_menu_url', 'like', 'classified%')
            ->orWhere('url', 'like', 'classified%')
            ->delete();

        Setting::where('category', 'Classified')->delete();

        Media::whereIn('collection_name', ['classified-media-collection'])->delete();
    }
}
