<?php

namespace Corals\Modules\Slider\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SliderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('key')->unique()->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['images', 'videos', 'html']);
            $table->text('init_options')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('slider_id');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('slider_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('default');
            $table->string('type');
            $table->text('values');
            $table->text('description');
            $table->string('slider_type')->default('OwlCarousel2');
            $table->boolean('hidden')->default(false);

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
        Schema::table('slides', function (Blueprint $table) {
            $table->dropForeign('slides_slider_id_foreign');
        });
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('slides');
        Schema::dropIfExists('slider_options');
    }
}
