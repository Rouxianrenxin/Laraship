<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('plans', 'is_visible')) {
    Schema::table('plans', function (Blueprint $table) {
        $table->boolean('is_visible')->default(true)->after('free_plan');
    });
}

rescue(function () {
    $subscriptionNotification = new \Corals\Modules\Subscriptions\database\seeds\SubscriptionNotificationTemplatesSeeder();
    $subscriptionNotification->run();
});


if (!Schema::hasColumn('subscriptions', 'next_billing_at')) {
    Schema::table('subscriptions', function (Blueprint $table) {
        $table->timestamp('next_billing_at')->nullable();
    });
}

\DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('canceled','pending','active') DEFAULT 'active' ");
