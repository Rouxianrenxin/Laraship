<?php

namespace Corals\Modules\Utility\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryAttributeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            
            $table->string('module')->nullable();

            $table->unsignedInteger('parent_id')->nullable()->default(0);

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('utility_attributes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type');
            $table->string('label');
            $table->integer('display_order')->default(0);
            $table->boolean('use_as_filter')->default(false);
            $table->boolean('required')->default(false);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('utility_category_attributes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('attribute_id')->index();
            $table->unsignedInteger('category_id')->index();

            $table->foreign('attribute_id')
                ->references('id')->on('utility_attributes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('category_id')->references('id')
                ->on('utility_categories')
                ->onUpdate('cascade')->onDelete('cascade');
        });


        Schema::create('utility_attribute_options', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('attribute_id')->unsigned()->index();
            $table->integer('option_order');
            $table->string('option_value');
            $table->string('option_display');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->foreign('attribute_id')->references('id')
                ->on('utility_attributes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('utility_model_has_category', function (Blueprint $table) {
            $table->unsignedInteger('model_id');
            $table->string('model_type');

            $table->unsignedInteger('category_id');

            $table->foreign('category_id')
                ->references('id')
                ->on('utility_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('utility_model_attribute_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->unsigned()->index()->nullable();
            $table->unsignedInteger('attribute_option_id')->nullable()->index();

            $table->unsignedInteger('model_id');
            $table->string('model_type');

            $table->string('string_value', 255)->nullable();
            $table->double('number_value')->nullable();
            $table->text('text_value')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->foreign('attribute_id')
                ->references('id')->on('utility_attributes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('attribute_option_id')
                ->references('id')
                ->on('utility_attribute_options')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('utility_model_attribute_options');
        Schema::dropIfExists('utility_model_has_category');
        Schema::dropIfExists('utility_attribute_options');
        Schema::dropIfExists('utility_category_attributes');
        Schema::dropIfExists('utility_attributes');
        Schema::dropIfExists('utility_categories');
    }
}
