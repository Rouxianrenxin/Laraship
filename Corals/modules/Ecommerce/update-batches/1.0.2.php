<?php

use \Corals\Modules\Ecommerce\Models\Product;


\DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

if (\Schema::hasTable('ecommerce_products') && !\Schema::hasColumn('ecommerce_products', 'slug')) {
    \Schema::table('ecommerce_products', function ($table) {
        $table->string('slug')->index();
    });
}


$products = Product::all();
foreach ($products as $product) {
    //Generate dlug
    $product->save();
}

\Schema::table('ecommerce_products', function ($table) {
    $table->string('slug')->unique()->index()->change();
});

if (\Schema::hasTable('ecommerce_sku') && !\Schema::hasColumn('ecommerce_sku', 'allowed_quantity')) {
    \Schema::table('ecommerce_sku', function ($table) {
        $table->integer('allowed_quantity')->default(0);
    });
}
