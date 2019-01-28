<?php

return [
    'invoice' => [
        'invoicable_type' => 'Type',
        'invoicable_id' => 'Details',
        'user_id' => 'User',
        'total' => 'Total',
        'sub_total' => 'Sub Total',
        'description' => 'Description',
        'code' => 'Code',
        'due_date' => 'Due Date',
        'invoice_code' => 'Invoice Code',
        'status' => 'Status',
        'invoice_option' => [
            'paid' => 'Paid',
            'failed' => 'Failed',
            'pending' => 'Pending'
        ],
        'currency' => 'Currency',
    ],
    'tax_class' => [
        'name' => 'Name'
    ],
    'tax' => [
        'name' => 'Name',
        'country' => 'Country',
        'state' => 'State',
        'zip' => 'Zip',
        'rate' => 'Rate',
        'priority' => 'Priority',
        'compound' => 'Compound',
    ],
    'webhook_call' => [
        'event_name' => 'Event',
        'payload' => 'Payload',
        'exception' => 'Exception',
        'gateway' => 'Gateway',
        'processed' => 'Processed',
        'process' => 'Process',
    ],
    'currency' => [
        'name' => 'Name',
        'code' => 'Code',
        'symbol' => 'Symbol',
        'format' => 'Format',
        'exchange_rate' => 'Exchange rate',
    ],
    'transaction' => [
        'invoice' => 'Invoice',
        'type' => 'Type',
        'source' => 'Source',
        'amount' => 'Amount',
        'status' => 'Status',
        'currency' => 'Currency',
        'notes' => 'Notes',
        'reference' => 'Reference',
        'paid_amount' => 'Paid Amount',
        'types' => [
            'order_revenue' => 'Order Sale',
            'commision' => 'Commision',
            'withdrawal' => 'Withdrawal',
            'shipping' => 'Shipping'
        ]

    ]
];