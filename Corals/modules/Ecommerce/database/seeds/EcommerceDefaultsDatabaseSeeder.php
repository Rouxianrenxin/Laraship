<?php

namespace Corals\Modules\Ecommerce\database\seeds;

use Illuminate\Database\Seeder;

class EcommerceDefaultsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // seed ecommerce default uncategorized category
        \DB::table('ecommerce_categories')->insert([
                ['parent_id' => null,
                    'slug' => 'uncategorized',
                    'description' => 'Default product category',
                    'status' => 'active',
                    'name' => 'Uncategorized',
                ]
            ]
        );
    }
}
