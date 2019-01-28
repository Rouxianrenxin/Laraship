<?php

return [
    'invoice' => [
        'invoicable_type' => 'النوع',
        'invoicable_id' => 'التفاصيل',
        'user_id' => 'المستخدم',
        'total' => 'المجموع',
        'sub_total' => 'المجموع الفرعي',
        'description' => 'الوصف',
        'code' => 'الكود',
        'due_date' => 'تاريخ الاستحقاق',
        'invoice_code' => 'رمز الفاتورة',

        'invoice_option' => [
            'paid' => 'دفع',
            'failed' => 'فشل',
            'pending' => 'قيد الانتظار'
        ],
        'currency' => 'دقة',
    ],
    'tax_class' => [
        'name' => 'الاسم'
    ],
    'tax' => [
        'name' => 'الاسم',
        'country' => 'البلد',
        'state' => 'حالة',
        'zip' => 'الرمز البريدي',
        'rate' => 'معدل',
        'priority' => 'الأولوية',
        'compound' => 'مجمع',
    ],
    'webhook_call' => [
        'event_name' => 'حدث',
        'payload' => 'حمولة',
        'exception' => 'استثناء',
        'gateway' => 'بوابة',
        'processed' => 'معالجة',
    ],
    'currency' => [
        'name' => 'الاسم',
        'code' => 'الكود',
        'symbol' => 'الرمز',
        'format' => 'الشكل',
        'exchange_rate' => 'سعر الصرف',
    ]


];