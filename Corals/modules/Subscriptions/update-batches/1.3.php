<?php

try {

    if (\Schema::hasTable('subscriptions') && !\Schema::hasColumn('subscriptions', 'gateway')) {

        \Schema::table('subscriptions', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->text('gateway')->after('status')->nullable();
        });


        \Schema::table('subscriptions', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->longText('extras')->after('status')->nullable();
        });

        \Schema::table('invoices', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->longText('extras')->after('status')->nullable();
        });

        \Schema::table('plans', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->longText('extras')->after('status')->nullable();
        });

        \Schema::table('features', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->longText('extras')->after('status')->nullable();
        });

        \Schema::table('products', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->longText('products')->after('status')->nullable();
        });
        $subscriptions = \Corals\Modules\Subscriptions\Models\Subscription::all();
        foreach ($subscriptions as $subscription) {
            $subscription->gateway = $subscription->user->gateway;
            $subscription->save();
        }
    }
} catch (\Exception $exception) {
    log_exception($exception);
}
