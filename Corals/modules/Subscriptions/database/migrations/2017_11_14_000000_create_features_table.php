<?php

namespace Corals\Modules\Subscriptions\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('caption');
            $table->text('description')->nullable();
            $table->unsignedInteger('product_id');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->enum('type', ['quantity', 'boolean', 'text'])->default('boolean');
            $table->unsignedInteger('display_order')->default(0);
            $table->text('unit')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
