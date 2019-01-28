<?php

Schema::table('slides', function (\Illuminate\Database\Schema\Blueprint $table) {
    $table->text('description')->after('name')->nullable();
});
