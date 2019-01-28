<?php

// Subscriptions
Breadcrumbs::register('payments', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Payment::module.payment.title'));
});

Breadcrumbs::register('webhook_calls', function ($breadcrumbs) {
    $breadcrumbs->parent('payments');
    $breadcrumbs->push(trans('Payment::module.webhook.title'));
});



//Settings
Breadcrumbs::register('payment_settings', function ($breadcrumbs) {
    $breadcrumbs->parent('payments');
    $breadcrumbs->push(trans('Payment::module.setting.title'), url(config('payment_common.resource_url') . '/settings'));
});

//Invoices
Breadcrumbs::register('invoices', function ($breadcrumbs) {
    $breadcrumbs->parent('payments');
    $breadcrumbs->push(trans('Payment::module.invoice.title'), url(config('payment_common.models.invoice.resource_url')));
});

//Transactions
Breadcrumbs::register('transactions', function ($breadcrumbs) {
    $breadcrumbs->parent('payments');
    $breadcrumbs->push(trans('Payment::module.transaction.title'), url(config('payment_common.models.transaction.resource_url')));
});

Breadcrumbs::register('transaction_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('transactions');
    $breadcrumbs->push(trans('Payment::module.transaction.title'), url(config('payment_common.models.transaction.resource_url')));
});


Breadcrumbs::register('currencies', function ($breadcrumbs) {
    $breadcrumbs->parent('payments');
    $breadcrumbs->push(trans('Payment::module.currency.title'), url(config('payment_common.models.currency.resource_url')));
});


Breadcrumbs::register('currencies_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('payments');
    $breadcrumbs->push(trans('Payment::module.currency.title'), url(config('payment_common.models.invoice.resource_url')));
});

Breadcrumbs::register('invoice_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('invoices');
    $breadcrumbs->push(trans('Payment::module.invoice.title'), url(config('payment_common.models.invoice.resource_url')));
});


Breadcrumbs::register('tax', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Payment::module.tax.title_singular'));
});


Breadcrumbs::register('tax_classes', function ($breadcrumbs) {
    $breadcrumbs->parent('tax');
    $breadcrumbs->push(trans('Payment::module.tax_class.title_singular'), url(config('payment_common.models.tax_class.resource_url')));
});


Breadcrumbs::register('taxes', function ($breadcrumbs, $tax_class) {
    $breadcrumbs->parent('tax_classes');
    $breadcrumbs->push(trans('Payment::module.tax.name', ['name' => $tax_class->name]), route(config('payment_common.models.tax.resource_route'), ['tax_class' => $tax_class->hashed_id]));
});

Breadcrumbs::register('tax_create_edit', function ($breadcrumbs, $tax_class) {
    $breadcrumbs->parent('tax_classes', $tax_class);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('tax_show', function ($breadcrumbs, $tax_class) {
    $breadcrumbs->parent('tax_classes', $tax_class);
    $breadcrumbs->push(view()->shared('title_singular'));
});