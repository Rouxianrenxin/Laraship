<?php

namespace Corals\Modules\CMS\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CMSMenusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cms_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'cms',
            'url' => null,
            'active_menu_url' => 'cms*',
            'name' => 'CMS',
            'description' => 'CMS Menu Item',
            'icon' => 'fa fa-desktop',
            'target' => null,
            'roles' => '["1"]',
            'order' => 0
        ]);

        // seed users children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => config('cms.models.page.resource_url'),
                    'active_menu_url' => config('cms.models.page.resource_url') . '*',
                    'name' => 'Pages',
                    'description' => 'Pages List Menu Item',
                    'icon' => 'fa fa-files-o',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => config('cms.models.post.resource_url'),
                    'active_menu_url' => config('cms.models.post.resource_url') . '*',
                    'name' => 'Posts',
                    'description' => 'Posts List Menu Item',
                    'icon' => 'fa fa-thumb-tack',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => config('cms.models.category.resource_url'),
                    'active_menu_url' => config('cms.models.category.resource_url') . '*',
                    'name' => 'Categories',
                    'description' => 'Categories List Menu Item',
                    'icon' => 'fa fa-folder-open',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => 'cms/blog',
                    'active_menu_url' => 'cms/blog*',
                    'name' => 'Internal Content',
                    'description' => 'Internal Content List Menu Item',
                    'icon' => 'fa fa-book',
                    'target' => null,
                    'roles' => '["1","2"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => config('cms.models.news.resource_url'),
                    'active_menu_url' => config('cms.models.news.resource_url') . '*',
                    'name' => 'News',
                    'description' => 'News List Menu Item',
                    'icon' => 'fa fa-newspaper-o',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => config('cms.models.faq.resource_url'),
                    'active_menu_url' => config('cms.models.faq.resource_url') . '*',
                    'name' => 'FAQ',
                    'description' => 'FAQ List Menu Item',
                    'icon' => 'fa fa-question-circle-o',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $cms_menu_id,
                    'key' => null,
                    'url' => config('cms.models.block.resource_url'),
                    'active_menu_url' => config('cms.models.block.resource_url') . '*',
                    'name' => 'Blocks',
                    'description' => 'Block List Menu Item',
                    'icon' => 'fa fa-cube',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
