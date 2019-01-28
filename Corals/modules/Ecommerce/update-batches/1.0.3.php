<?php

\Corals\Settings\Models\Setting::where('code', ['supported_shipping_methods'])
    ->update(['category' => 'Ecommerce']);

if (\Schema::hasTable('ecommerce_products') && !\Schema::hasColumn('ecommerce_products', 'external_url')) {
    \Schema::table('ecommerce_products', function ($table) {
        $table->text('external_url')->nullable();
    });
}
