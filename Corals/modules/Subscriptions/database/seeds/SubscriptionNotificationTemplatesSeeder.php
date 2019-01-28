<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Corals\User\Communication\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class SubscriptionNotificationTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTemplate::updateOrCreate(['name' => 'notifications.subscription.created'], [
            'friendly_name' => 'Subscription Created',
            'title' => '{plan_name} subscription has been created',
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
<br/>
<br/>
Thanks.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{dashboard_link}" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Visit your Dashboard</a></td></tr></tbody></table></td></tr></tbody></table>',
                'database' => 'You have been subscribed successfully to <b>{plan_name}</b> plan'
            ],
            'via' => ["mail", "database", "user_preferences"]
        ]);


        NotificationTemplate::updateOrCreate(['name' => 'notifications.subscription.approved'], [
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


        NotificationTemplate::updateOrCreate(['name' => 'notifications.subscription.swapped'], [
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


        NotificationTemplate::updateOrCreate(['name' => 'notifications.subscription.cancelled'], [
            'friendly_name' => 'Subscription Cancelled',
            'title' => '{plan_name} subscription has been cancelled',
            'body' => [
                'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Dear {user},</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
Your subscription to <b>{plan_name}</b> plan has been cancelled successfully.
<br/>
Your subscription details was:<br/>
    - subscription reference: {reference},<br/> 
    - subscription created at: {created_at},<br/> 
    - subscription ends at: {ends_at},<br/> 
    - subscription plan name: {plan_name} - {product_name},<br/> 
    - subscription plan price: {plan_price},<br/> 
    - subscription plan bill frequency: {plan_frequency},<br/> 
    - subscription plan bill cycle: {plan_cycle},<br/> 
<br/>
<br/>
Thanks.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{dashboard_link}" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Visit your Dashboard</a></td></tr></tbody></table></td></tr></tbody></table>',
                'database' => 'Your subscription to <b>{plan_name}</b> plan has been cancelled successfully.'
            ],
            'via' => ["mail", "database", "user_preferences"]
        ]);
    }
}