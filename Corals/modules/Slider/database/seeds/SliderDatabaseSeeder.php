<?php

namespace Corals\Modules\Slider\database\seeds;

use Illuminate\Database\Seeder;

class SliderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SliderOptionsDatabaseSeeder::class);
        $this->call(SliderPermissionsDatabaseSeeder::class);
        $this->call(SlidersDemoTableSeeder::class);
        $this->call(SlidesDemoTableSeeder::class);

        $slider_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,
            'key' => null,
            'url' => config('slider.models.slider.resource_url'),
            'active_menu_url' => config('slider.models.slider.resource_url') . '*',
            'name' => 'Sliders',
            'description' => 'Sliders List Menu Item',
            'icon' => 'fa fa-clone',
            'target' => null,
            'roles' => '["1"]',
            'order' => 0
        ]);
    }
}
