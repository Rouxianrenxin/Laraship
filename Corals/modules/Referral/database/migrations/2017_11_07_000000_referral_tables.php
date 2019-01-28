<?php

namespace Corals\Modules\Referral\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReferralTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('referral_programs')) {

            Schema::create('referral_programs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('referral_action');
                $table->string('uri');
                $table->string('title');
                $table->text('description');
                $table->text('options')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');

                $table->unsignedInteger('created_by')->nullable()->index();
                $table->unsignedInteger('updated_by')->nullable()->index();

                $table->softDeletes();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('referral_links')) {

            Schema::create('referral_links', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('referral_program_id')->unsigned();
                $table->string('code', 36)->index();
                $table->softDeletes();
                $table->timestamps();
                $table->unsignedInteger('created_by')->nullable()->index();
                $table->unsignedInteger('updated_by')->nullable()->index();
                $table->foreign('referral_program_id')->references('id')->on('referral_programs')->onDelete('cascade');

            });
        }

        Schema::create('referral_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referral_link_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('reward')->unsigned();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->foreign('referral_link_id')->references('id')->on('referral_links')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('reward_points')->unsigned()->nullable()->dafault(null);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('referral_links')) {
            Schema::table('referral_links', function (Blueprint $table) {
                $table->dropForeign('referral_links_referral_program_id_foreign');
            });
        }


        Schema::dropIfExists('referral_relationships');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('reward_points');
        });

        Schema::dropIfExists('referral_links');

        Schema::dropIfExists('referral_programs');

    }
}
