<?php

namespace Corals\Modules\Amazon\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AmazonTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_imports', function (Blueprint $table) {
            $table->string('title');
            $table->increments('id');
            $table->text('keywords');
            $table->integer('image_count');
            $table->integer('max_result_pages');
            $table->enum('status', ['canceled', 'pending', 'in_progress', 'completed', 'failed'])->default('pending')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('amazon_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('amazon_import_product', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('import_id');
            $table->foreign('import_id')->references('id')->on('amazon_imports')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['product_id', 'import_id']);
        });

        Schema::create('amazon_category_import', function (Blueprint $table) {
            $table->unsignedInteger('amazon_category_id');
            $table->foreign('amazon_category_id')->references('id')->on('amazon_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('import_id');
            $table->foreign('import_id')->references('id')->on('amazon_imports')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['import_id', 'amazon_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_category_import');
        Schema::dropIfExists('amazon_import_product');
        Schema::dropIfExists('amazon_imports');
        Schema::dropIfExists('amazon_categories');

    }
}
