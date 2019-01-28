<?php

namespace Corals\Modules\Utility\database\migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        \Schema::create('utility_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body');
            $table->morphs('commentable');
            $table->morphs('author');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('utility_comments');
    }
}
