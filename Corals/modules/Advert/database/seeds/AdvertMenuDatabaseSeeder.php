<?php

namespace Corals\Modules\Advert\database\seeds;

use Illuminate\Database\Seeder;

class AdvertMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Advert_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'advert',
            'url' => null,
            'active_menu_url' => 'adverts*',
            'name' => 'Advertisement',
            'description' => 'Advert Menu Item',
            'icon' => 'fa fa-bullhorn',
            'target' => null, 'roles' => '["1"]',
            'order' => 0
        ]);

        // seed subscriptions children menu
        \DB::table('menus')->insert([
                [
                    'parent_id' => $Advert_menu_id,
                    'key' => 'adverts-advertisers',
                    'url' => config('advert.models.advertiser.resource_url'),
                    'active_menu_url' => config('advert.models.advertiser.resource_url') . '*',
                    'name' => 'Advertisers',
                    'description' => 'Advertisers List Menu Item',
                    'icon' => 'fa fa-users',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $Advert_menu_id,
                    'key' => 'adverts-campaigns',
                    'url' => config('advert.models.campaign.resource_url'),
                    'active_menu_url' => config('advert.models.campaign.resource_url') . '*',
                    'name' => 'Campaigns',
                    'description' => 'Campaigns List Menu Item',
                    'icon' => 'fa fa-hand-peace-o',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $Advert_menu_id,
                    'key' => 'adverts-banners',
                    'url' => config('advert.models.banner.resource_url'),
                    'active_menu_url' => config('advert.models.banner.resource_url') . '*',
                    'name' => 'Banners',
                    'description' => 'Banners List Menu Item',
                    'icon' => 'fa fa-film',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $Advert_menu_id,
                    'key' => 'adverts-websites',
                    'url' => config('advert.models.website.resource_url'),
                    'active_menu_url' => config('advert.models.website.resource_url') . '*',
                    'name' => 'Websites',
                    'description' => 'Websites List Menu Item',
                    'icon' => 'fa fa-globe',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $Advert_menu_id,
                    'key' => 'adverts-zones',
                    'url' => config('advert.models.zone.resource_url'),
                    'active_menu_url' => config('advert.models.zone.resource_url') . '*',
                    'name' => 'Zones',
                    'description' => 'Zones List Menu Item',
                    'icon' => 'fa fa-crop',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
                [
                    'parent_id' => $Advert_menu_id,
                    'key' => 'adverts-impressions',
                    'url' => config('advert.models.impression.resource_url'),
                    'active_menu_url' => config('advert.models.impression.resource_url') . '*',
                    'name' => 'Impressions',
                    'description' => 'Impressions List Menu Item',
                    'icon' => 'fa fa-list',
                    'target' => null, 'roles' => '["1"]',
                    'order' => 0
                ],
            ]
        );
    }
}
