<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Illuminate\Database\Seeder;

class SubscriptionsMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'subscriptions',
            'url' => null,
            'active_menu_url' => 'subscriptions*',
            'name' => 'Subscriptions',
            'description' => 'Subscriptions Menu Item',
            'icon' => 'fa fa-id-card-o',
            'target' => null, 'roles' => '["1"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $subscriptions_menu_id,
                    'key' => null,
                    'url' => 'subscriptions/products',
                    'active_menu_url' => 'subscriptions/products*',
                    'name' => 'Rucurring Products',
                    'description' => 'Products List Menu Item',
                    'icon' => 'fa fa-retweet',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $subscriptions_menu_id,
                    'key' => null,
                    'url' => 'subscriptions',
                    'active_menu_url' => 'subscriptions',
                    'name' => 'Subscriptions',
                    'description' => 'Subscriptions List Menu Item',
                    'icon' => 'fa fa-bars',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ]
            ]
        );
    }
}
