<?php

namespace Corals\Modules\Foo\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FooSettingsDatabaseSeeder extends Seeder
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
                'code' => 'foo_setting',
                'type' => 'TEXT',
                'category' => 'Foo',
                'label' => 'Foo setting',
                'value' => 'foo',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
