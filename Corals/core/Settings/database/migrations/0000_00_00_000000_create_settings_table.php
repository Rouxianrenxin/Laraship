<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->index();
            $table->enum('type', ['BOOLEAN', 'NUMBER', 'DATE', 'TEXT', 'SELECT', 'FILE', 'TEXTAREA']);
            $table->string('category')->default('General');
            $table->string('label');
            $table->longText('value')->nullable();
            $table->boolean('editable')->default(1);
            $table->boolean('hidden')->default(0);
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('model_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->index();
            $table->integer('model_id');
            $table->string('model_type');
            $table->enum('cast_type', ['string', 'integer', 'boolean', 'float'])->default('string');
            $table->text('value')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
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

        Schema::dropIfExists('model_settings');
        Schema::dropIfExists('settings');
    }
}
