<?php

if (!\Schema::hasColumn('products', 'require_shipping_address')) {
    \Schema::table('products', function ($table) {
        $table->boolean('require_shipping_address')->default(false);
    });
}

if (!\Schema::hasColumn('subscriptions', 'billing_address')) {
    \Schema::table('subscriptions', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->longText('billing_address')->after('status')->nullable();
        $table->longText('shipping_address')->after('billing_address')->nullable();
    });
}

\DB::table('permissions')->insert([
    [
        'name' => 'Subscriptions::subscription.create',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'Subscriptions::subscription.update',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'Subscriptions::subscription.delete',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],

]);

\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.subscription.approved'], [
    'friendly_name' => 'Subscription Approved',
    'title' => '{plan_name} subscription has been approved',
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Dear {user},</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
Congratulations!, Your subscription to plan <b>{plan_name}</b> has been approved.
<br/>
Your subscription details:<br/>
    - subscription reference: {reference},<br/> 
    - subscription created at: {created_at},<br/> 
    - subscription plan name: {plan_name} - {product_name},<br/> 
    - subscription plan price: {plan_price},<br/> 
    - subscription plan bill frequency: {plan_frequency},<br/> 
    - subscription plan bill cycle: {plan_cycle},<br/> 
<br/>
<br/>
Thanks.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{dashboard_link}" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Visit your Dashboard</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => 'Congratulations!, Your subscription to plan : <b>{plan_name}</b> has been approved.'
    ],
    'via' => ["mail", "database", "user_preferences"]
]);


\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.subscription.swapped'], [
    'friendly_name' => 'Subscription Swapped',
    'title' => '{old_plan_name} subscription has been swapped to {plan_name}',
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Dear {user},</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
You have been subscribed successfully to <b>{plan_name}</b> plan.
<br/>
Your subscription details:<br/>
    - subscription reference: {reference},<br/> 
    - subscription created at: {created_at},<br/> 
    - subscription plan name: {plan_name} - {product_name},<br/> 
    - subscription plan price: {plan_price},<br/> 
    - subscription plan bill frequency: {plan_frequency},<br/> 
    - subscription plan bill cycle: {plan_cycle},<br/> 
    <hr/>
Old subscription details:<br/>
    - subscription reference: {old_reference},<br/> 
    - subscription created at: {old_created_at},<br/> 
    - subscription ends at: {old_ends_at},<br/> 
    - subscription plan name: {old_plan_name} - {product_name},<br/> 
    - subscription plan price: {old_plan_price},<br/> 
    - subscription plan bill frequency: {old_plan_frequency},<br/> 
    - subscription plan bill cycle: {old_plan_cycle},<br/> 
<br/>
<br/>
Thanks.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{dashboard_link}" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Visit your Dashboard</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => 'You have been subscribed successfully to <b>{plan_name}</b> plan'
    ],
    'via' => ["mail", "database", "user_preferences"]
]);
