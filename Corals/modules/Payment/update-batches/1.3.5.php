<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (Schema::hasTable('currencies')) {
    if (!Schema::hasColumn('currencies', 'created_by')) {
        Schema::table('currencies', function (Blueprint $table) {
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
        });
    }
} else {
    Schema::create('currencies', function (Blueprint $table) {
        $table->increments('id')->unsigned();
        $table->string('name');
        $table->string('code', 10)->index();
        $table->string('symbol', 25);
        $table->string('format', 50);
        $table->string('exchange_rate');
        $table->boolean('active')->default(false);

        $table->unsignedInteger('created_by')->nullable()->index();
        $table->unsignedInteger('updated_by')->nullable()->index();
        $table->timestamps();
    });
}

if (Corals\Menu\Models\Menu::query()->where('key', 'currencies')->count() === 0) {
    $payments_menu = \Corals\Menu\Models\Menu::query()->where('key', 'payment')->first();
    if ($payments_menu) {
        \DB::table('menus')->insert([
            [
                'parent_id' => $payments_menu->id,
                'key' => 'currencies',
                'url' => 'currencies',
                'active_menu_url' => 'currencies*',
                'name' => 'Currencies',
                'description' => 'currencies List Menu Item',
                'icon' => 'fa fa-money',
                'target' => null, 'roles' => '["1"]',
                'order' => 0
            ],
        ]);
    }
}