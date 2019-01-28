<?php

namespace Corals\Modules\Directory\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Communication\Models\NotificationTemplate;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class DirectoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DirectoryPermissionsDatabaseSeeder::class);
        $this->call(DirectoryMenuDatabaseSeeder::class);
        $this->call(DirectorySettingsDatabaseSeeder::class);
        $this->call(DirectoryNotificationTemplatesSeeder::class);
    }

    public function rollback()
    {

        Permission::where('name', 'like', 'Directory::%')->delete();

        Menu::where('key', 'directory')
            ->orWhere('active_menu_url', 'like', 'directorys%')
            ->orWhere('url', 'like', 'directorys%')
            ->delete();

        Setting::where('category', 'Directory')->delete();

        Media::whereIn('collection_name', ['directory-media-collection'])->delete();

        NotificationTemplate::where('name', 'like', 'notifications.directory%')->delete();
    }
}
