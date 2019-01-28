<?php

namespace Corals\Modules\Directory\database\seeds;

use Illuminate\Database\Seeder;

class DirectoryMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directory_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'directory',
            'url' => null,
            'active_menu_url' => 'directorys*',
            'name' => 'Directory',
            'description' => 'Directory Menu Item',
            'icon' => 'fa fa-th-large',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        \DB::table('menus')->insert([
                [
                    'parent_id' => $directory_menu_id,
                    'key' => null,
                    'url' => config('directory.models.listing.resource_url'),
                    'active_menu_url' => config('directory.models.listing.resource_url') . '*',
                    'name' => 'Listings',
                    'description' => 'Listings List Menu Item',
                    'icon' => 'fa fa-cube',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $directory_menu_id,
                    'key' => null,
                    'url' => config('directory.models.claim.resource_url'),
                    'active_menu_url' => config('directory.models.claim.resource_url') . '*',
                    'name' => 'Claims',
                    'description' => 'Listings Claims List Menu Item',
                    'icon' => 'fa fa-paperclip',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $directory_menu_id,
                    'key' => null,
                    'url' => config('directory.models.listing.user_resource_url'),
                    'active_menu_url' => config('directory.models.listing.user_resource_url'),
                    'name' => 'My Listings',
                    'description' => 'My Listings',
                    'icon' => 'fa fa-cube',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 1
                ], [
                    'parent_id' => $directory_menu_id,
                    'key' => null,
                    'url' => config('directory.models.wishlist.resource_url') . '/my',
                    'active_menu_url' => config('directory.models.wishlist.resource_url') . '/my',
                    'name' => 'My Wishlists',
                    'description' => 'My Wishlists',
                    'icon' => 'fa fa-heart',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 2
                ],
                [
                    'parent_id' => $directory_menu_id,
                    'key' => null,
                    'url' => config('directory.models.listing.review_resource_url'),
                    'active_menu_url' => config('directory.models.listing.review_resource_url'),
                    'name' => 'Reviews',
                    'description' => 'Reviews',
                    'icon' => 'fa fa-star',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 3
                ],
                [
                    'parent_id' => $directory_menu_id,
                    'key' => null,
                    'url' => config('directory.models.invite_friends.resource_url'),
                    'active_menu_url' => config('directory.models.invite_friends.resource_url'),
                    'name' => 'Invite Friends',
                    'description' => 'Invite Friends',
                    'icon' => 'fa fa-paper-plane-o',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 33
                ],
            ]
        );
    }
}
