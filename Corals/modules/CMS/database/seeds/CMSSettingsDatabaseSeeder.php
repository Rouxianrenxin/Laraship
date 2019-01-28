<?php

namespace Corals\Modules\CMS\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CMSSettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            [
                'code' => 'home_page_slug',
                'type' => 'TEXT',
                'category' => 'CMS',
                'label' => 'Home page slug',
                'value' => 'home',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'blog_page_slug',
                'type' => 'TEXT',
                'category' => 'CMS',
                'label' => 'Blog page slug',
                'value' => 'blog',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'pricing_page_slug',
                'type' => 'TEXT',
                'category' => 'CMS',
                'label' => 'Pricing page slug',
                'value' => 'pricing',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'faqs_page_slug',
                'type' => 'TEXT',
                'category' => 'CMS',
                'label' => 'Faqs page slug',
                'value' => 'faqs',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
