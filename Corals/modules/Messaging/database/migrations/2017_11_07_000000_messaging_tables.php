<?php

namespace Corals\Modules\Messaging\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MessagingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging_discussions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('subject')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->timestamps();
        });

        Schema::create('messaging_messages', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('discussion_id');
            $table->morphs('participable');
            $table->text('body');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->timestamps();
        });

        Schema::create('messaging_participations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('discussion_id');
            $table->morphs('participable');
            $table->timestamp('last_read')->nullable();

            $table->enum('status', ['read', 'unread', 'deleted', 'important', 'star'])->nullable()->default('unread');
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
        Schema::dropIfExists('messaging_discussions');
        Schema::dropIfExists('messaging_messages');
        Schema::dropIfExists('messaging_participations');
    }
}
