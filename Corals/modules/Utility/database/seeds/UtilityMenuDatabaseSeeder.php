<?php

namespace Corals\Modules\Utility\database\seeds;

use Illuminate\Database\Seeder;

class UtilityMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $utilities_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'utility',
            'url' => null,
            'active_menu_url' => 'utilities*',
            'name' => 'Utilities',
            'description' => 'Utilities Menu Item',
            'icon' => 'fa fa-cloud',
            'target' => null, 'roles' => '["1"]',
            'order' => 0
        ]);

        \DB::table('menus')->insert([
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.location.resource_url'),
                    'active_menu_url' => config('utility.models.location.resource_url') . '*',
                    'name' => 'Locations',
                    'description' => 'Locations List Menu Item',
                    'icon' => 'fa fa-map-o',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.tag.resource_url'),
                    'active_menu_url' => config('utility.models.tag.resource_url') . '*',
                    'name' => 'Tags',
                    'description' => 'Tags List Menu Item',
                    'icon' => 'fa fa-tags',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.category.resource_url'),
                    'active_menu_url' => config('utility.models.category.resource_url') . '*',
                    'name' => 'Categories',
                    'description' => 'Categories List Menu Item',
                    'icon' => 'fa fa-folder-open',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.attribute.resource_url'),
                    'active_menu_url' => config('utility.models.attribute.resource_url') . '*',
                    'name' => 'Attributes',
                    'description' => 'Attributes List Menu Item',
                    'icon' => 'fa fa-sliders',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.rating.resource_url'),
                    'active_menu_url' => config('utility.models.rating.resource_url') . '*',
                    'name' => 'Ratings',
                    'description' => 'Ratings List Menu Item',
                    'icon' => 'fa fa-star',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.comment.resource_url'),
                    'active_menu_url' => config('utility.models.comment.resource_url') . '*',
                    'name' => 'Comments',
                    'description' => 'Comments List Menu Item',
                    'icon' => 'fa fa-comment',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => config('utility.models.invite_friends.resource_url'),
                    'active_menu_url' => config('utility.models.invite_friends.resource_url') . '*',
                    'name' => 'Invite Friends',
                    'description' => 'Invite Friends Menu Item',
                    'icon' => 'fa fa-paper-plane-o',
                    'target' => null,
                    'roles' => '["1","2"]',
                    'order' => 0
                ]
            ]
        );
    }
}
