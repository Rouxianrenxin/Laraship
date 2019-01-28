<?php

namespace Corals\User\database\seeds;


use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersSettingsDatabaseSeeder extends Seeder
{

    public function run()
    {
        \DB::table('settings')->insert([
            [
                'code' => 'confirm_user_registration_email',
                'type' => 'BOOLEAN',
                'category' => 'User',
                'label' => 'Confirm email on registration?',
                'value' => 'false',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'cookie_consent',
                'type' => 'BOOLEAN',
                'category' => 'User',
                'label' => 'Enable Cookie Consent',
                'value' => 'false',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'cookie_consent_config',
                'type' => 'TEXTAREA',
                'category' => 'User',
                'label' => 'Cookie Consent Configuration',
                'value' => '{
                        type: "opt-in",
                        position: "bottom",
                        palette: { "popup": { "background": "#252e39" }, "button": { "background": "#14a7d0", padding: "5px 50px" } }
            
                    }',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'available_registration_roles',
                'type' => 'SELECT',
                'category' => 'User',
                'label' => 'Available registration roles',
                'value' => json_encode(['member' => 'Member']),
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }

}
