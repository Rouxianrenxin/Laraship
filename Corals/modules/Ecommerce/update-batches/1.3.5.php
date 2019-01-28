<?php

if (\Schema::hasTable('ecommerce_shippings') && !\Schema::hasColumn('ecommerce_shippings', 'name')) {
    \Schema::table('ecommerce_shippings', function ($table) {
        $table->string('name')->default('');
        $table->decimal('min_order_total')->default(0.0);
        $table->tinyInteger('exclusive')->default(0);

    });
}
$supported_shipping_methods = \Settings::get('supported_shipping_methods', []);
$supported_shipping_methods['Free'] = 'Free Shipping';
\Settings::set('supported_shipping_methods', json_encode($supported_shipping_methods));