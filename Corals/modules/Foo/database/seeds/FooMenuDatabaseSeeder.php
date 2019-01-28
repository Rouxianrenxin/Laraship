<?php

namespace Corals\Modules\Foo\database\seeds;

use Illuminate\Database\Seeder;

class FooMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foo_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'foo',
            'url' => null,
            'active_menu_url' => 'bars*',
            'name' => 'Foo',
            'description' => 'Foo Menu Item',
            'icon' => 'fa fa-globe',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $foo_menu_id,
                    'key' => null,
                    'url' => config('foo.models.bar.resource_url'),
                    'active_menu_url' => config('foo.models.bar.resource_url') . '*',
                    'name' => 'Bars',
                    'description' => 'Bars List Menu Item',
                    'icon' => 'fa fa-cube',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
