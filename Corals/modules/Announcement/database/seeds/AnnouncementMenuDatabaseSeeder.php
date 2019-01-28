<?php

namespace Corals\Modules\Announcement\database\seeds;

use Illuminate\Database\Seeder;

class AnnouncementMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcement_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'announcement',
            'url' => null,
            'active_menu_url' => 'announcements*',
            'name' => 'Announcement',
            'description' => 'Announcement Menu Item',
            'icon' => 'fa fa-bell-o',
            'target' => null, 'roles' => '["1"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $announcement_menu_id,
                    'key' => null,
                    'url' => config('announcement.models.announcement.resource_url'),
                    'active_menu_url' => config('announcement.models.announcement.resource_url') . '*',
                    'name' => 'Announcements',
                    'description' => 'Announcements List Menu Item',
                    'icon' => 'fa fa-bell-o',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
