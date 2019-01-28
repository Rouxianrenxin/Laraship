<?php

use \Corals\Modules\Payment\Common\database\migrations\CreateTransactionsTable;
use \Carbon\Carbon;

if (!\Schema::hasTable('payment_transactions')) {

    \Schema::create('payment_transactions', function (\Illuminate\Database\Schema\Blueprint $table) {

        $table->increments('id');

        $table->morphs('owner');


        $table->unsignedInteger('invoice_id')->nullable();

        $table->morphs('sourcable');
        $table->float('amount')->default(0);
        $table->string('paid_currency')->nullable();
        $table->float('paid_amount')->nullable();
        $table->string('type')->nullable();
        $table->string('method')->nullable();
        $table->timestamp('transaction_date')->nullable();
        $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');

        $table->text('notes')->nullable();
        $table->text('extra')->nullable();
        $table->string('reference')->nullable();

        $table->unsignedInteger('created_by')->nullable()->index();
        $table->unsignedInteger('updated_by')->nullable()->index();

        $table->softDeletes();
        $table->timestamps();

        $table->foreign('invoice_id')->references('id')
            ->on('invoices')->onDelete('cascade')->onUpdate('cascade');
    });


    $payments_menu = \Corals\Menu\Models\Menu::where('key', 'payment')->first();

    if ($payments_menu) {
        $payments_menu_id = $payments_menu->id;

        \Corals\Menu\Models\Menu::updateOrCreate(['parent_id' => $payments_menu_id, 'key' => 'transactions'], [
            [
                'parent_id' => $payments_menu_id,
                'key' => 'payment_transactions',
                'url' => 'transactions',
                'active_menu_url' => 'transactions*',
                'name' => 'Transactions',
                'description' => 'Transactions List Menu Item',
                'icon' => 'fa fa-exchange',
                'target' => null,
                'roles' => '["1"]',
                'order' => 0
            ]
        ]);
    }


    \DB::table('permissions')->insert([
        [
            'name' => 'Payment::transaction.view_all',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Payment::transaction.view',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Payment::transaction.create',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Payment::transaction.update',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Payment::transaction.delete',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'Payment::invoices.view',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Payment::invoices.delete',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'Payment::invoices.update',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]

    ]);


    $member_role = \Corals\User\Models\Role::where('name', 'member')->first();
    if ($member_role) {
        $member_role->forgetCachedPermissions();
        if (!$member_role->hasPermissionTo('Payment::invoices.view')) {
            $member_role->givePermissionTo('Payment::invoices.view');

        }
    }
}