<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('model');
            $table->string('type');
            $table->string('name');
            $table->string('label')->nullable();
            $table->boolean('required')->default(false);
            $table->text('options')->nullable();
            $table->text('options_options')->nullable();
            $table->text('custom_attributes')->nullable();
            $table->string('default_value')->nullable();
            $table->string('validation_rules')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('custom_fields', function (Blueprint $table) {
            $table->increments('id');

            $table->string('parent_type');
            $table->unsignedInteger('parent_id');
            $table->string('field_name');

            $table->string('string_value', 255)->nullable();
            $table->double('number_value')->nullable();
            $table->text('text_value')->nullable();
            $table->text('multi_value')->nullable();
            $table->timestamp('date_value')->nullable();

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
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('custom_field_settings');
    }
}
