<?php

namespace Corals\Modules\CMS\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class CMSDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CMSPermissionsDatabaseSeeder::class);
        $this->call(CMSMenusDatabaseSeeder::class);
        $this->call(CMSDemoDatabaseSeeder::class);
        $this->call(CMSSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'CMS::%')->delete();
        Permission::where('name', 'Administrations::admin.cms')->delete();


        Setting::whereIn('code', ['home_page_slug', 'blog_page_slug', 'pricing_page_slug', 'faqs_page_slug'])->delete();

        $cms_menus = Menu::whereIn('key', ['cms', 'frontend_top', 'frontend_footer'])->get();

        foreach ($cms_menus as $menu) {
            Menu::where('parent_id', $menu->id)->delete();
            $menu->delete();
        }
    }
}
