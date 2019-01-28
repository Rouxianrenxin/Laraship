<?php

namespace Corals\Modules\Advert\database\seeds;

use Illuminate\Database\Seeder;

class AdvertDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdvertPermissionsDatabaseSeeder::class);
        $this->call(AdvertMenuDatabaseSeeder::class);
        $this->call(AdvertSampleDatabaseSeeder::class);
    }
}
