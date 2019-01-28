<?php

namespace Corals\Modules\Subscriptions\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('subscriptions') &&! Schema::hasColumn('subscriptions', 'gateway')) {

            Schema::table('subscriptions', function (Blueprint $table) {
                $table->text('gateway')->after('status')->nullable();
            });

            Schema::table('subscriptions', function (Blueprint $table) {
                $table->longText('extras')->after('gateway')->nullable();
            });

            Schema::table('invoices', function (Blueprint $table) {
                $table->longText('extras')->after('status')->nullable();
            });

            Schema::table('plans', function (Blueprint $table) {
                $table->longText('extras')->after('status')->nullable();
            });

            Schema::table('features', function (Blueprint $table) {
                $table->longText('extras')->after('status')->nullable();
            });

            Schema::table('products', function (Blueprint $table) {
                $table->longText('extras')->after('status')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('subscriptions') && Schema::hasColumn('subscriptions', 'extras')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('extras');
            });

            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('gateway');
            });
        }

        if (Schema::hasTable('invoices') && Schema::hasColumn('invoices', 'extras')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('extras');
            });
        }

        if (Schema::hasTable('plans') && Schema::hasColumn('plans', 'extras')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->dropColumn('extras');
            });
        }

        if (Schema::hasTable('features') && Schema::hasColumn('features', 'extras')) {
            Schema::table('features', function (Blueprint $table) {
                $table->dropColumn('extras');
            });
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'extras')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('extras');
            });
        }

    }
}
