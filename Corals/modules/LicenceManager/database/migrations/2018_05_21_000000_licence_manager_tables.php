<?php

namespace Corals\Modules\LicenceManager\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LicenceManagerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licence_manager_licences', function (Blueprint $table) {
            $table->increments('id');

            $table->text('code');
            $table->enum('status', ['free', 'reserved', 'cancelled', 'invalid', 'expired'])->default('free');

            $table->string('licenceable_type');// Product
            $table->unsignedInteger('licenceable_id');// product id

            $table->string('parent_type')->nullable();// order
            $table->unsignedInteger('parent_id')->nullable();// order id

            $table->integer('expiry_period')->default(0);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licence_manager_licences');
    }
}
