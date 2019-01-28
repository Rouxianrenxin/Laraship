<?php

namespace Corals\Modules\Amazon\database\seeds;

use Illuminate\Database\Seeder;

class AmazonMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amazon_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'amazon',
            'url' => null,
            'active_menu_url' => 'amazon*',
            'name' => 'Amazon',
            'description' => 'Amazon Menu Item',
            'icon' => 'fa fa-amazon',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $amazon_menu_id,
                    'key' => null,
                    'url' => config('amazon.models.import.resource_url'),
                    'active_menu_url' => config('amazon.models.import.resource_url') . '*',
                    'name' => 'Imports',
                    'description' => 'Imports List Menu Item',
                    'icon' => 'fa fa-upload',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
        // seed users children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $amazon_menu_id,
                    'key' => null,
                    'url' => 'amazon/settings',
                    'active_menu_url' => 'amazon/settings*',
                    'name' => 'Amazon Settings',
                    'description' => 'Amazon Settings Menu Item',
                    'icon' => 'fa fa-cog fa-fw',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
