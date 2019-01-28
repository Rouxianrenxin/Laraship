<?php

namespace Corals\Modules\CMS\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturedImageLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('featured_image_link')->after('template')->nullable();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->longText('extras')->after('featured_image_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'featured_image_link')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('featured_image_link');
            });
        }

        if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'extras')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('extras');
            });
        }
    }
}
