<?php

use \Illuminate\Database\Schema\Blueprint;

if (!\Schema::hasTable('postables') ) {

    \Schema::create('postables', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('content_id');
        $table->morphs('postable');
        $table->morphs('sourcable');
        $table->timestamps();
    });
}