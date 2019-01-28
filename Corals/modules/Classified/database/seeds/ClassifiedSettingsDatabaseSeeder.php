<?php

namespace Corals\Modules\Classified\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClassifiedSettingsDatabaseSeeder extends Seeder
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
                'code' => 'classified_auth_theme',
                'type' => 'TEXT',
                'category' => 'Classified',
                'label' => 'Auth theme code',
                'value' => 'corals-classified',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'classified_product_condition_options',
                'type' => 'SELECT',
                'category' => 'Classified',
                'label' => 'Product condition options',
                'value' => json_encode(['new' => 'New', 'used' => 'Used', 'refurbished' => 'Refurbished']),
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'classified_wishlist_enable',
                'type' => 'BOOLEAN',
                'category' => 'Classified',
                'label' => 'Enable Wishlist',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'classified_rating_enable',
                'type' => 'BOOLEAN',
                'category' => 'Classified',
                'label' => 'Enable Rating',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'classified_appearance_page_limit',
                'type' => 'number',
                'category' => 'Classified',
                'label' => 'Product page limit',
                'value' => 10,
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'classified_messaging_is_enable',
                'type' => 'BOOLEAN',
                'category' => 'Classified',
                'label' => 'Enable Internal Messaging',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
