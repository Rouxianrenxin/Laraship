<?php

namespace Corals\Modules\Messaging\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class MessagingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MessagingPermissionsDatabaseSeeder::class);
        $this->call(MessagingMenuDatabaseSeeder::class);
        $this->call(MessagingSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Messaging::%')->delete();

        Menu::where('key', 'messaging')
            ->orWhere('active_menu_url', 'like', 'messagings%')
            ->orWhere('url', 'like', 'messagings%')
            ->delete();

        Setting::where('category', 'Messaging')->delete();

        Media::whereIn('collection_name', ['messaging-media-collection'])->delete();
    }
}
