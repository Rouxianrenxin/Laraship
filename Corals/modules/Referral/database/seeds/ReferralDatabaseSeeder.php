<?php

namespace Corals\Modules\Referral\database\seeds;

use Illuminate\Database\Seeder;

class ReferralDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ReferralProgramPermissionsDatabaseSeeder::class);
        $this->call(ReferralLinkPermissionsDatabaseSeeder::class);
        $this->call(ReferralProgramsDemoTableSeeder::class);
        $this->call(ReferralLinksDemoTableSeeder::class);
        $this->call(ReferralMenusDatabaseSeeder::class);


    }
}
