<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::table('announcements', function (Blueprint $table) {
    $table->string('link_title')->nullable();
});