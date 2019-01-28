<?php

namespace Corals\Modules\Ecommerce\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number');
            $table->decimal('amount');
            $table->string('currency');
            $table->string('status');
            $table->text('shipping')->nullable();
            $table->text('billing')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('ecommerce_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount');
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('type');
            $table->text('item_options')->nullable();

            $table->unsignedInteger('order_id');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();


            $table->foreign('order_id')->references('id')
                ->on('ecommerce_orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_order_items');
        Schema::dropIfExists('ecommerce_orders');
    }
}
