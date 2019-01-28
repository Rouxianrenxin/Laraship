<?php

if (\Schema::hasTable('ecommerce_categories') && !\Schema::hasColumn('ecommerce_categories', 'external_id')) {
    \Schema::table('ecommerce_categories', function ($table) {
        $table->string('external_id')->nullable();
    });
}