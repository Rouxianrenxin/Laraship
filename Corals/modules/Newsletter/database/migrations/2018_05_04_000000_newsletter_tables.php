<?php

namespace Corals\Modules\Newsletter\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsletterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_mail_lists', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('newsletter_mail_list_subscriber', function (Blueprint $table) {
            $table->integer('list_id')->unsigned()->index();
            $table->integer('subscriber_id')->unsigned()->index();

            $table->foreign('list_id')->references('id')->on('newsletter_mail_lists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subscriber_id')->references('id')->on('newsletter_subscribers')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('newsletter_emails', function (Blueprint $table) {
            $table->increments('id');

            $table->string('from', 512)->nullable();
            $table->string('reply_to', 512)->nullable();
            $table->string('subject', 255);
            $table->mediumText('email_body');
            $table->text('mail_lists')->nullable();
            $table->text('subscribers')->nullable();
            $table->enum('status', ['draft', 'sent', 'trash'])->default('draft');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('newsletter_email_logger', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscriber_id')->unsigned()->index();
            $table->integer('email_id')->unsigned()->index();
            $table->string('api_call_id', 255)->index();
            $table->enum('status', ['draft', 'sent', 'opened', 'failed'])->default('draft');
            $table->text('failure_message')->nullable();
            $table->string('ip', 32)->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();
            $table->text('languages')->nullable();
            $table->text('extras')->nullable();

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subscriber_id')->references('id')->on('newsletter_subscribers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('email_id')->references('id')->on('newsletter_emails')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_mail_list_subscriber');
        Schema::dropIfExists('newsletter_email_logger');
        Schema::dropIfExists('newsletter_mail_lists');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('newsletter_emails');

    }
}
