<?php

namespace Corals\Modules\Foo\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Media;

class FooDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FooPermissionsDatabaseSeeder::class);
        $this->call(FooMenuDatabaseSeeder::class);
        $this->call(FooSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Foo::%')->delete();

        Menu::where('key', 'foo')
            ->orWhere('active_menu_url', 'like', 'foos%')
            ->orWhere('url', 'like', 'foos%')
            ->delete();

        Setting::where('category', 'Foo')->delete();

        Media::whereIn('collection_name', ['foo-media-collection'])->delete();
    }
}
