<?php

namespace Corals\Modules\Announcement\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnnouncementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('link', 255)->nullable();
            $table->string('link_title')->nullable();

            $table->text('content')->nullable();

            $table->date('starts_at');
            $table->date('ends_at');

            $table->boolean('show_immediately')->default(false);
            $table->boolean('is_public')->default(false);
            $table->string('show_in_url')->nullable();
            $table->text('properties')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('announcement_tracking', function (Blueprint $table) {
            $table->unsignedInteger('announcement_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('read_at');

            $table->foreign('announcement_id')
                ->references('id')
                ->on('announcements')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_tracking');
        Schema::dropIfExists('announcements');
    }
}
