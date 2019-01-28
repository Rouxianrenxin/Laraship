<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\User\Communication\Models\NotificationTemplate;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class SubscriptionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SubscriptionsPermissionsDatabaseSeeder::class);
        $this->call(SubscriptionsMenuDatabaseSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(FeaturesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(FeaturePlanTableSeeder::class);
        $this->call(SubscriptionNotificationTemplatesSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Subscriptions::%')->delete();
        Permission::where('name', 'Administrations::admin.subscription')->delete();

        $key_menu = Menu::where('key', 'subscriptions')->first();
        if ($key_menu) {
            Menu::where('parent_id', $key_menu->id)->delete();
            $key_menu->delete();
        }

        NotificationTemplate::where('name', 'like', 'notifications.subscription%')->delete();
    }
}
