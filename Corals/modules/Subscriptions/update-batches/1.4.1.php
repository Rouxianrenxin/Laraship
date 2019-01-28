<?php

use Corals\User\Models\Role;

try{

    \DB::table('permissions')->insert([
        [
            'name' => 'Subscriptions::subscriptions.subscribe',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]
    ]);


    $member_role = Role::where('name', 'member')->first();

    if ($member_role) {
        $member_role->forgetCachedPermissions();
        $member_role->givePermissionTo('Subscriptions::subscriptions.subscribe');


    }
} catch (\Exception $exception) {
    log_exception($exception);
}




?>