<?php

namespace Corals\Modules\Subscriptions\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('price');
            $table->integer('bill_frequency')->default(1);
            $table->integer('trial_period')->default(0);
            $table->enum('bill_cycle', ['week', 'month', 'year'])->default('month');
            $table->boolean('recommended')->default(false);
            $table->boolean('free_plan')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->tinyInteger('display_order')->default(0);
            $table->text('description')->nullable();
            $table->unsignedInteger('product_id');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');

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
        Schema::dropIfExists('plans');
    }
}
