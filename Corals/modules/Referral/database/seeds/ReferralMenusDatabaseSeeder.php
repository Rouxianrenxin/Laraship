<?php

namespace Corals\Modules\Referral\database\seeds;

use Illuminate\Database\Seeder;

class ReferralMenusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $referral_program_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,
            'key' => null,
            'url' => '#',
            'active_menu_url' => 'referral*',
            'name' => 'Referrals',
            'description' => 'Referrals List Menu Item',
            'icon' => 'fa fa-retweet',
            'target' => null,
            'roles' => '["1","2"]',
            'order' => 0
        ]);


        // seed users children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $referral_program_menu_id,
                    'key' => null,
                    'url' => config('referral_program.models.referral_program.resource_url'),
                    'active_menu_url' => config('referral_program.models.referral_program.resource_url') . '*',
                    'name' => 'Referral Programs',
                    'description' => 'Programs List Menu Item',
                    'icon' => 'fa fa-list-alt',
                    'target' => null,
                    'roles' => '["1","2"]',
                    'order' => 0
                ],
            ]
        );
        // seed users children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $referral_program_menu_id,
                    'key' => null,
                    'url' => 'referral/my-referrals',
                    'active_menu_url' =>  'referral/my-referrals',
                    'name' => 'My Referrals',
                    'description' => 'Referrals List Menu Item',
                    'icon' => 'fa fa-list-alt',
                    'target' => null,
                    'roles' => '["2"]',
                    'order' => 2
                ],
            ]
        );
    }
}
