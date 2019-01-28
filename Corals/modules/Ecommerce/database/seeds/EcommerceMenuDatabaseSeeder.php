<?php

namespace Corals\Modules\Ecommerce\database\seeds;

use Illuminate\Database\Seeder;

class EcommerceMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ecommerce_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'ecommerce',
            'url' => null,
            'active_menu_url' => 'e-commerce*',
            'name' => 'Ecommerce',
            'description' => 'Ecommerce Menu Item',
            'icon' => 'fa fa-globe',
            'target' => null, 'roles' => '["1","2"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.product.resource_url'),
                    'active_menu_url' => config('ecommerce.models.product.resource_url') . '*',
                    'name' => 'Products',
                    'description' => 'Products List Menu Item',
                    'icon' => 'fa fa-cube',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => 'e-commerce/shop',
                    'active_menu_url' => 'e-commerce/shop*',
                    'name' => 'Shop',
                    'description' => 'Shop Menu Item',
                    'icon' => 'fa fa-building',
                    'target' => null, 'roles' => '["1","2"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => 'e-commerce/downloads/my',
                    'active_menu_url' =>'e-commerce/downloads/my',
                    'name' => 'My Downloads',
                    'description' => 'My Downloads Menu Item',
                    'icon' => 'fa fa-download',
                    'target' => null, 'roles' => '["2"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => 'e-commerce/private-pages/my',
                    'active_menu_url' =>'e-commerce/private-pages/my',
                    'name' => 'My Private Pages',
                    'description' => 'My Private Pages Menu Item',
                    'icon' => 'fa fa-file',
                    'target' => null, 'roles' => '["2"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.order.resource_url') . '/my',
                    'active_menu_url' => config('ecommerce.models.order.resource_url') . '/my',
                    'name' => 'My Orders',
                    'description' => 'My Orders Menu Item',
                    'icon' => 'fa fa-send-o',
                    'target' => null, 'roles' => '["2"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.wishlist.resource_url') . '/my',
                    'active_menu_url' => config('ecommerce.models.wishlist.resource_url') . '/my',
                    'name' => 'My Wishlist',
                    'description' => 'My Wishlist Menu Item',
                    'icon' => 'fa fa-heart',
                    'target' => null, 'roles' => '["2"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.order.resource_url'),
                    'active_menu_url' => config('ecommerce.models.order.resource_url'),
                    'name' => 'Orders',
                    'description' => 'Orders Menu Item',
                    'icon' => 'fa fa-send-o',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],

                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.category.resource_url'),
                    'active_menu_url' => config('ecommerce.models.category.resource_url') . '*',
                    'name' => 'Categories',
                    'description' => 'Categories List Menu Item',
                    'icon' => 'fa fa-folder-open',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.attribute.resource_url'),
                    'active_menu_url' => config('ecommerce.models.attribute.resource_url') . '*',
                    'name' => 'Attributes',
                    'description' => 'Attributes List Menu Item',
                    'icon' => 'fa fa-sliders',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.tag.resource_url'),
                    'active_menu_url' => config('ecommerce.models.tag.resource_url') . '*',
                    'name' => 'Tags',
                    'description' => 'Tags List Menu Item',
                    'icon' => 'fa fa-tags',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.brand.resource_url'),
                    'active_menu_url' => config('ecommerce.models.brand.resource_url') . '*',
                    'name' => 'Brands',
                    'description' => 'Brands List Menu Item',
                    'icon' => 'fa fa-cubes',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.coupon.resource_url'),
                    'active_menu_url' => config('ecommerce.models.coupon.resource_url') . '*',
                    'name' => 'Coupons',
                    'description' => 'Coupons List Menu Item',
                    'icon' => 'fa fa-gift',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => config('ecommerce.models.shipping.resource_url'),
                    'active_menu_url' => config('ecommerce.models.shipping.resource_url') . '*',
                    'name' => 'Shipping Rules',
                    'description' => 'Shippings List Menu Item',
                    'icon' => 'fa fa-truck',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $ecommerce_menu_id,
                    'key' => null,
                    'url' => 'e-commerce/settings',
                    'active_menu_url' => 'e-commerce/settings',
                    'name' => 'Settings',
                    'description' => 'Settings Menu Item',
                    'icon' => 'fa fa-cog',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
