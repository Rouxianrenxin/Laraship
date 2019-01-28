<?php

namespace Corals\Modules\Classified\database\seeds;

use Illuminate\Database\Seeder;

class ClassifiedMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classified_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'classified',
            'url' => null,
            'active_menu_url' => 'classified*',
            'name' => 'Classifieds',
            'description' => 'Classified Menu Item',
            'icon' => 'fa fa-list',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        \DB::table('menus')->insert([
                [
                    'parent_id' => $classified_menu_id,
                    'key' => null,
                    'url' => config('classified.models.product.resource_url'),
                    'active_menu_url' => config('classified.models.product.resource_url') . '*',
                    'name' => 'Products',
                    'description' => 'Products List Menu Item',
                    'icon' => 'fa fa-cube',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $classified_menu_id,
                    'key' => null,
                    'url' => config('classified.models.wishlist.resource_url') . '/my',
                    'active_menu_url' => config('classified.models.wishlist.resource_url') . '/my',
                    'name' => 'My Wishlists',
                    'description' => 'My Wishlists',
                    'icon' => 'fa fa-heart',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 0
                ]
                ,
                [
                    'parent_id' => $classified_menu_id,
                    'key' => null,
                    'url' => config('classified.models.product.user_resource_url'),
                    'active_menu_url' => config('classified.models.product.user_resource_url'),
                    'name' => 'My Products',
                    'description' => 'My Products',
                    'icon' => 'fa fa-cube',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 0
                ]
            ]
        );
    }
}
