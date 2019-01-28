<?php

if (\Schema::hasTable('posts') && !\Schema::hasColumn('posts', 'internal')) {
    try {
        \Schema::table('posts', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->boolean('internal')->after('private')->default(false);
        });
    } catch (\Exception $exception) {
        log_exception($exception);
    }
}
