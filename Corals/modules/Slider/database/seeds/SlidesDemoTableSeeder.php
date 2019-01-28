<?php

namespace Corals\Modules\Slider\database\seeds;

use Illuminate\Database\Seeder;

class SlidesDemoTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('slides')->delete();

        \DB::table('slides')->insert(array(
            array(
                'id' => 1,
                'name' => 'First Slider',
                'content' => '/media/demo/1/banner1.png',
                'slider_id' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2017-12-03 22:53:48',
                'updated_at' => '2017-12-03 23:24:42',
            ),
            array(
                'id' => 2,
                'name' => 'Second Slider',
                'content' => '/media/demo/2/banner2.png',
                'slider_id' => 1,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2017-12-03 23:24:55',
                'updated_at' => '2017-12-03 23:24:55',
            ),
            array(
                'id' => 4,
                'name' => 'Q8 Smart Band Review',
                'content' => 'https://youtu.be/4MqbwYPAHCg',
                'slider_id' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2017-12-03 23:25:09',
                'updated_at' => '2017-12-03 23:25:09',
            ),
            array(
                'id' => 5,
                'name' => 'camera FPV',
                'content' => 'https://youtu.be/L8vL19CBF-8',
                'slider_id' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2017-12-03 23:25:09',
                'updated_at' => '2017-12-03 23:25:09',
            ),
            array(
                'id' => 6,
                'name' => 'iPhone, iPad, iPod l IOS 11',
                'content' => 'https://youtu.be/8iRk-G3dVKo',
                'slider_id' => 2,
                'status' => 'active',
                'deleted_at' => NULL,
                'created_at' => '2017-12-03 23:25:09',
                'updated_at' => '2017-12-03 23:25:09',
            ),
        ));
    }
}