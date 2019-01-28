<?php

namespace Corals\Modules\Ecommerce\database\seeds;

use Carbon\Carbon;
use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class EcommerceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EcommercePermissionsDatabaseSeeder::class);
        $this->call(EcommerceMenuDatabaseSeeder::class);
        $this->call(EcommerceDefaultsDatabaseSeeder::class);
        $this->call(EcommerceNotificationTemplatesSeeder::class);

        \DB::table('settings')->insert([
            [
                'code' => 'supported_shipping_methods',
                'type' => 'SELECT',
                'category' => 'Ecommerce',
                'label' => 'Supported Shipping methods',
                'value' => json_encode(['FlatRate' => 'Flat Rate', 'Shippo' => 'Shippo', 'Free' => 'Free']),
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Ecommerce%')->delete();
        Permission::where('name', 'Administrations::admin.announcement')->delete();


        Setting::where('code', 'supported_shipping_methods')->delete();

        $menus = Menu::where('key', 'ecommerce')->get();

        foreach ($menus as $menu) {
            Menu::where('parent_id', $menu->id)->delete();
            $menu->delete();
        }

        Setting::where('code', 'like', 'ecommerce_%')->delete();
    }
}
