<?php

namespace Corals\Modules\Messaging\database\seeds;

use Illuminate\Database\Seeder;

class MessagingMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messaging_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'messaging',
            'url' => null,
            'active_menu_url' => 'discussions*',
            'name' => 'Messaging',
            'description' => 'Messaging Menu Item',
            'icon' => 'fa fa-envelope',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $messaging_menu_id,
                    'key' => null,
                    'url' => config('messaging.models.discussion.resource_url'),
                    'active_menu_url' => config('messaging.models.discussion.resource_url') . '*',
                    'name' => 'Discussions',
                    'description' => 'Discussions List Menu Item',
                    'icon' => 'fa fa-comments',
                    'target' => null, 'roles' => '["1","2"]',
                    'order' => 0
                ],
            ]
        );
    }
}
