<?php

namespace Corals\Modules\Newsletter\database\seeds;

use Illuminate\Database\Seeder;

class NewsletterMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsletter_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'newsletter',
            'url' => null,
            'active_menu_url' => 'newsletter*',
            'name' => 'Newsletter',
            'description' => 'Newsletter Menu Item',
            'icon' => 'fa fa-file-text-o',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                // Mail-list
                [
                    'parent_id' => $newsletter_menu_id,
                    'key' => null,
                    'url' => config('newsletter.models.mail_list.resource_url'),
                    'active_menu_url' => config('newsletter.models.mail_list.resource_url') . '*',
                    'name' => 'Mail lists',
                    'description' => 'Mail list List Menu Item',
                    'icon' => 'fa fa-list',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                // Subscriber
                [
                    'parent_id' => $newsletter_menu_id,
                    'key' => null,
                    'url' => config('newsletter.models.subscriber.resource_url'),
                    'active_menu_url' => config('newsletter.models.subscriber.resource_url') . '*',
                    'name' => 'Subscribers',
                    'description' => 'Subscribers List Menu Item',
                    'icon' => 'fa fa-id-card-o',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );

        // E-Mail
        $newsletter_email_id = \DB::table('menus')->insertGetId([
            'parent_id' => $newsletter_menu_id,
            'key' => null,
            'url' => config('newsletter.models.email.resource_url'),
            'active_menu_url' => config('newsletter.models.email.resource_url') . '*' . ',' . config('newsletter.models.email_logger.resource_url') . '*',
            'name' => 'Emails',
            'description' => 'Emails List Menu Item',
            'icon' => 'fa fa-envelope',
            'target' => null, 'roles' => '["1"]',
            'order' => 0

        ]);
        \DB::table('menus')->insert([
                // E-Mail
                [
                    'parent_id' => $newsletter_email_id,
                    'key' => null,
                    'url' => config('newsletter.models.email.resource_url'),
                    'active_menu_url' => config('newsletter.models.email.resource_url') . '*',
                    'name' => 'Emails',
                    'description' => 'Emails List Menu Item',
                    'icon' => 'fa fa-envelope',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                // E-Mail Logger
                [
                    'parent_id' => $newsletter_email_id,
                    'key' => null,
                    'url' => config('newsletter.models.email_logger.resource_url'),
                    'active_menu_url' => config('newsletter.models.email_logger.resource_url') . '*',
                    'name' => 'Email Stats',
                    'description' => 'Email Stats List Menu Item',
                    'icon' => 'fa fa-envelope',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );


    }
}
