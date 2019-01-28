<?php

namespace Corals\Modules\LicenceManager\database\seeds;

use Illuminate\Database\Seeder;

class LicenceManagerMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $licenceManager_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'licence_manager',
            'url' => null,
            'active_menu_url' => 'licences*',
            'name' => 'Licence Manager',
            'description' => 'Licence Manager Menu Item',
            'icon' => 'fa fa-barcode',
            'target' => null, 'roles' => '["1"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $licenceManager_menu_id,
                    'key' => null,
                    'url' => config('licence_manager.models.licence.resource_url'),
                    'active_menu_url' => config('licence_manager.models.licence.resource_url') . '*',
                    'name' => 'Licences',
                    'description' => 'Licences List Menu Item',
                    'icon' => 'fa fa-list',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
