<?php


return [
    'resource_url' => 'payments',
    'models' => [
        'invoice' => [
            'presenter' => \Corals\Modules\Payment\Common\Transformers\InvoicePresenter::class,
            'resource_url' => 'invoices',
            'statuses' => [
                'paid' => 'Payment::attributes.invoice.invoice_option.paid',
                'failed' => 'Payment::attributes.invoice.invoice_option.failed',
                'pending' => 'Payment::attributes.invoice.invoice_option.pending'
            ]
        ],
        'webhook_call' => [
            'presenter' => \Corals\Modules\Payment\Common\Transformers\WebhookCallPresenter::class,
            'resource_url' => 'webhook-calls',
        ],
        'transaction' => [
            'presenter' => \Corals\Modules\Payment\Common\Transformers\TransactionPresenter::class,
            'resource_url' => 'transactions',
        ],
        'tax_class' => [
            'presenter' => \Corals\Modules\Payment\Common\Transformers\TaxClassPresenter::class,
            'resource_url' => 'tax/tax-classes',
        ],
        'tax' => [
            'presenter' => \Corals\Modules\Payment\Common\Transformers\TaxPresenter::class,
            'resource_route' => 'tax-classes.taxes.index',
        ],
        'currency' => [
            'presenter' => \Corals\Modules\Payment\Common\Transformers\CurrencyPresenter::class,
            'resource_url' => 'currencies'
        ],
    ]
];

