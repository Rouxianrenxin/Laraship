<?php

namespace Corals\Modules\Slider\database\seeds;

use Illuminate\Database\Seeder;

class SlidersDemoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('sliders')->delete();

        \DB::table('sliders')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Home Page Slider',
                    'key' => 'home-page-slider',
                    'status' => 'active',
                    'type' => 'images',
                    'init_options' => '{"items":{"number":"1"},"margin":{"number":"0"},"loop":{"boolean":"false"},"center":{"boolean":"false"},"mouseDrag":{"boolean":"true"},"touchDrag":{"boolean":"true"},"stagePadding":{"number":"0"},"merge":{"boolean":"false"},"mergeFit":{"boolean":"true"},"autoWidth":{"boolean":"false"},"URLhashListener":{"boolean":"false"},"nav":{"boolean":"false"},"rewind":{"boolean":"true"},"navText":{"array":"[\'next\',\'prev\']"},"dots":{"boolean":"true"},"dotsEach":{"number\\/boolean":"false"},"dotData":{"boolean":"false"},"lazyLoad":{"boolean":"true"},"lazyContent":{"boolean":"true"},"autoplay":{"boolean":"true"},"autoplayTimeout":{"number":"3000"},"autoplayHoverPause":{"boolean":"true"},"autoplaySpeed":{"number\\/boolean":"false"},"navSpeed":{"number\\/boolean":"false"},"dotsSpeed":{"number\\/boolean":"false"},"dragEndSpeed":{"number\\/boolean":"false"},"callbacks":{"boolean":"true"},"responsive":{"object":"false"},"video":{"boolean":"false"},"videoHeight":{"number\\/boolean":"false"},"videoWidth":{"number\\/boolean":"false"},"animateOut":{"array\\/boolean":"false"},"animateIn":{"array\\/boolean":"false"}}',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 22:53:20',
                    'updated_at' => '2017-12-03 23:13:24',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Tech Show Slider',
                    'key' => 'tech-show',
                    'status' => 'active',
                    'type' => 'videos',
                    'init_options' => '{"items":{"number":"1"},"margin":{"number":"0"},"loop":{"boolean":"true"},"center":{"boolean":"true"},"mouseDrag":{"boolean":"true"},"touchDrag":{"boolean":"true"},"stagePadding":{"number":"0"},"merge":{"boolean":"false"},"mergeFit":{"boolean":"true"},"autoWidth":{"boolean":"false"},"URLhashListener":{"boolean":"false"},"nav":{"boolean":"false"},"rewind":{"boolean":"true"},"navText":{"array":"[\'next\',\'prev\']"},"dots":{"boolean":"true"},"dotsEach":{"number\/boolean":"false"},"dotData":{"boolean":"false"},"lazyLoad":{"boolean":"true"},"lazyContent":{"boolean":"true"},"autoplay":{"boolean":"false"},"autoplayTimeout":{"number":"5000"},"autoplayHoverPause":{"boolean":"false"},"autoplaySpeed":{"number\/boolean":"false"},"navSpeed":{"number\/boolean":"false"},"dotsSpeed":{"number\/boolean":"false"},"dragEndSpeed":{"number\/boolean":"false"},"callbacks":{"boolean":"true"},"responsive":{"object":"false"},"video":{"boolean":"true"},"videoHeight":{"number\/boolean":"400"},"videoWidth":{"number\/boolean":"false"},"animateOut":{"array\/boolean":"false"},"animateIn":{"array\/boolean":"false"}}',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 22:53:20',
                    'updated_at' => '2017-12-03 23:13:24',
                ),
        ));


    }
}