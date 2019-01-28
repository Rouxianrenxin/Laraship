<?php

$invoicePermissions = [
    'Payment::invoices.view',
    'Payment::invoices.view_all',
    'Payment::invoices.create',
    'Payment::invoices.update',
    'Payment::invoices.delete',
];

foreach ($invoicePermissions as $permission) {
    \DB::table('permissions')->updateOrInsert(['name' => $permission], [
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
