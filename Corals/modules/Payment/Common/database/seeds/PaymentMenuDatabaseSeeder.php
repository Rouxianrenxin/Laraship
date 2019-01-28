<?php

namespace Corals\Modules\Payment\Common\database\seeds;

use Illuminate\Database\Seeder;

class PaymentMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'payment',
            'url' => null,
            'active_menu_url' => 'payments*',
            'name' => 'Payments',
            'description' => 'Payments Menu Item',
            'icon' => 'fa fa-money',
            'target' => null, 'roles' => '["1"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $payments_menu_id,
                    'key' => null,
                    'url' => 'payments/settings',
                    'active_menu_url' => 'payments/settings',
                    'name' => 'Payment Settings',
                    'description' => 'Payment Settings List Menu Item',
                    'icon' => 'fa fa-cog',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $payments_menu_id,
                    'key' => null,
                    'url' => 'webhook-calls',
                    'active_menu_url' => 'webhook-calls',
                    'name' => 'Webhook Calls',
                    'description' => 'Webhook List Menu Item',
                    'icon' => 'fa fa-anchor',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $payments_menu_id,
                    'key' => null,
                    'url' => 'invoices',
                    'active_menu_url' => 'invoices*',
                    'name' => 'Invoices',
                    'description' => 'Invoices List Menu Item',
                    'icon' => 'fa fa-file-text-o',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $payments_menu_id,
                    'key' => 'payment-taxes',
                    'url' => 'tax/tax-classes',
                    'active_menu_url' => 'tax/tax-classes',
                    'name' => 'Tax Classes',
                    'description' => 'Tax Classes List Menu Item',
                    'icon' => 'fa fa-cut',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $payments_menu_id,
                    'key' => 'currencies',
                    'url' => 'currencies',
                    'active_menu_url' => 'currencies*',
                    'name' => 'Currencies',
                    'description' => 'currencies List Menu Item',
                    'icon' => 'fa fa-money',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $payments_menu_id,
                    'key' => 'payment_transactions',
                    'url' => 'transactions',
                    'active_menu_url' => 'transactions*',
                    'name' => 'Transactions',
                    'description' => 'Transactions List Menu Item',
                    'icon' => 'fa fa-exchange',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ]
            ]
        );
    }
}
