<?php

namespace Corals\Modules\Advert\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvertsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_advertisers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('contact');
            $table->string('email');
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->nullableMorphs('owner');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('advert_campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();

            $table->date('starts_at');
            // ends_at is null when the campaign not expired
            $table->date('ends_at')->nullable();

            $table->integer('weight');
            $table->string('limit_type')->nullable();
            $table->integer('limit_per_day')->nullable();

            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('advertiser_id');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('advertiser_id')
                ->references('id')
                ->on('advert_advertisers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('advert_banners', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('dimension');
            $table->string('type');
            $table->text('content')->nullable();
            $table->integer('weight');
            $table->string('url')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('campaign_id');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('campaign_id')
                ->references('id')
                ->on('advert_campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('advert_websites', function (Blueprint $table) {
            $table->increments('id');

            $table->string('url');
            $table->string('name')->unique();
            $table->string('contact');
            $table->string('email');
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('advert_zones', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('key')->unique();
            $table->string('dimension');
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('website_id');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('website_id')
                ->references('id')
                ->on('advert_websites')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('advert_banner_zone', function (Blueprint $table) {
            $table->unsignedInteger('banner_id');
            $table->unsignedInteger('zone_id');

            $table->foreign('banner_id')
                ->references('id')
                ->on('advert_banners')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('zone_id')
                ->references('id')
                ->on('advert_zones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('advert_impressions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('banner_id');
            $table->unsignedInteger('zone_id');
            $table->string('session_id');
            $table->string('page_slug');
            $table->string('impression_slug');
            $table->boolean('clicked')->default(false);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('banner_id')
                ->references('id')
                ->on('advert_banners')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('zone_id')
                ->references('id')
                ->on('advert_zones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('advert_imp_visitor_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('impression_id');

            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->boolean('is_phone')->default(false);
            $table->boolean('is_tablet')->default(false);
            $table->boolean('is_desktop')->default(false);
            $table->boolean('is_robot')->default(false);
            $table->string('robot')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->text('languages')->nullable();
            $table->text('extras')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('impression_id')
                ->references('id')
                ->on('advert_impressions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_banner_zone');
        Schema::dropIfExists('advert_imp_visitor_details');
        Schema::dropIfExists('advert_impressions');
        Schema::dropIfExists('advert_banners');
        Schema::dropIfExists('advert_zones');
        Schema::dropIfExists('advert_websites');
        Schema::dropIfExists('advert_campaigns');
        Schema::dropIfExists('advert_advertisers');
    }
}
