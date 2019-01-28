<?php

namespace Corals\Modules\Amazon\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AmazonSettingsDatabaseSeeder extends Seeder
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
                'code' => 'amazon_api_access_key',
                'type' => 'TEXT',
                'category' => 'Amazon',
                'label' => 'Amazon API Access Key',
                'value' => 'AAKIAITDLHKTOMCB35JAQ',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'amazon_api_access_secret',
                'type' => 'TEXT',
                'category' => 'Amazon',
                'label' => 'Amazon API Access Secret',
                'value' => 'AmI7QVsxUgHqvETm+zK1EXKP/G0LS575I03pqZ5kh',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'amazon_api_country',
                'type' => 'TEXT',
                'category' => 'Amazon',
                'label' => 'Amazon Country',
                'value' => 'com',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'amazon_api_associate_tag',
                'type' => 'TEXT',
                'category' => 'Amazon',
                'label' => 'Amazon Associate Tag',
                'value' => 'laraship01',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
