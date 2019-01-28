<?php

namespace Corals\Modules\Messaging\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MessagingSettingsDatabaseSeeder extends Seeder
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
                'code' => 'messaging_pagination_number',
                'type' => 'TEXT',
                'category' => 'Messaging',
                'label' => 'Messaging Pagination Number',
                'value' => '10',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'messaging_is_multiple_participations',
                'type' => 'BOOLEAN',
                'category' => 'Messaging',
                'label' => 'Messaging Multiple Participations',
                'value' => 'false',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
