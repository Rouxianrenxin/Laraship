<?php

namespace Corals\Modules\Payment\Common\database\seeds;

use Carbon\Carbon;
use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class PaymentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(CurrenciesTableSeeder::class);
        $this->call(PaymentPermissionsDatabaseSeeder::class);
        $this->call(PaymentMenuDatabaseSeeder::class);

        \DB::table('settings')->insert([
            [
                'code' => 'supported_payment_gateway',
                'type' => 'SELECT',
                'category' => 'Payment',
                'label' => 'Supported payment gateway',
                'value' => json_encode([]),
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'admin_currency_code',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'Administration Currency Code',
                'value' => 'USD',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }

    public function rollback()
    {
        Setting::where('code', 'like', 'payment_%')->delete();

        Setting::where('code', 'supported_payment_gateway')->delete();
        Setting::where('code', 'admin_currency_code')->delete();

        Permission::where('name', 'like', 'Payment::%')->delete();
        Permission::where('name', 'Administrations::admin.payment')->delete();

        $key_menu = Menu::where('key', 'payment')->first();
        if ($key_menu) {
            Menu::where('parent_id', $key_menu->id)->delete();
            $key_menu->delete();
        }
    }
}
