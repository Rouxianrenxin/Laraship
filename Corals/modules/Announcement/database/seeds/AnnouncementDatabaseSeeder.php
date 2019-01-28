<?php

namespace Corals\Modules\Announcement\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Modules\Announcement\Models\Announcement;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class AnnouncementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AnnouncementPermissionsDatabaseSeeder::class);
        $this->call(AnnouncementMenuDatabaseSeeder::class);
        $this->call(AnnouncementSettingsDatabaseSeeder::class);
        $this->call(AnnouncementDemoDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Announcement::%')->delete();
        Permission::where('name', 'Administrations::admin.announcement')->delete();

        Menu::where('key', 'announcement')
            ->orWhere('active_menu_url', 'like', 'announcements%')
            ->orWhere('url', 'like', 'announcements%')
            ->delete();

        Setting::where('category', 'Announcement')->delete();

        Media::whereIn('collection_name', ['announcement-media-collection'])->delete();

        \DB::table('model_has_roles')
            ->where('model_type', Announcement::class)
            ->delete();
    }
}
