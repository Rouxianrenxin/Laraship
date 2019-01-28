<?php

if (\Schema::hasTable('posts') && !\Schema::hasColumn('posts', 'featured_image_link')) {
    try {

        \Schema::table('posts', function ($table) {
            $table->string('template')->change();
        });

        \Schema::table('posts', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('featured_image_link')->after('template')->nullable();
        });
        \Schema::table('posts', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('extras')->after('featured_image_link')->nullable();
        });
    } catch (\Exception $exception) {
        log_exception($exception);
    }
}
