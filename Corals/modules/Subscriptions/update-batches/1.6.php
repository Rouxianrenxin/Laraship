<?php

use \Illuminate\Database\Schema\Blueprint;

if (!\Schema::hasTable('subscribables')) {

    \Schema::create('subscribables', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('plan_id');
        $table->morphs('subscribable');
        $table->timestamps();
    });
}