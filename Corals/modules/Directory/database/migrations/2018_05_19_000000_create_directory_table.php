<?php

namespace Corals\Modules\Directory\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_listings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('lat')->nullable();;
            $table->string('long')->nullable();;
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'archived', 'deleted', 'pending'])->default('active');
            $table->text('caption')->nullable();
            $table->integer('visitors_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('verified')->default(false);
            $table->text('properties')->nullable();
            $table->unsignedInteger('location_id')->index();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('location_id')->references('id')->on('utility_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_listings');
    }
}
