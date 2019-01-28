<?php

namespace Corals\Modules\Newsletter\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class NewsletterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(NewsletterPermissionsDatabaseSeeder::class);
        $this->call(NewsletterMenuDatabaseSeeder::class);
        $this->call(NewsletterSettingsDatabaseSeeder::class);
        $this->call(NewsletterSamplesDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Newsletter::%')->delete();

        Menu::where('key', 'newsletter')
            ->orWhere('active_menu_url', 'like', 'newsletter%')
            ->orWhere('url', 'like', 'newsletter%')
            ->delete();

        Setting::where('category', 'Newsletter')->delete();

        Media::whereIn('collection_name', ['newsletter-media-collection'])->delete();
    }
}
