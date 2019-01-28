<?php

namespace Corals\Modules\Utility\database\migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTables extends Migration
{
    public function up()
    {
        \Schema::create('utility_locations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();;
            $table->string('zip')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('slug')->unique()->index();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->string('module')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('utility_locations');
    }
}