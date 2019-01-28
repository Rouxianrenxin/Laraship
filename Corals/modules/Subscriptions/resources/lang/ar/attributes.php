<?php


return [
    'feature' => [
        'display_order' => 'ترتيب العرض',
        'id' => 'Id',
        'name' => 'الاسم',
        'caption' => 'الوصف',
        'unit' => 'الوحدة',
        'type' => 'النوع',
        'type_option' =>
            ['quantity' => 'كمية',
                'text' => 'نصي',
                'boolean' => 'قيمة منطقية'
            ],
        'description' => 'الوصف'
    ],
    'plan' => [
        'id' => 'Id',
        'name' => 'الاسم',
        'name_help' => 'اسم سهل الاستعمال لهذه الباقه، والتي سوف يتم عرضها في جدول التسعير الخاصة بك.',
        'price' => 'سعر',
        'price_help' => 'تكلفة هذه الباقه ، لكل فترة',
        'bill_cycle' => 'فاتورة دورة',
        'display_order' => 'عرض الطلبات',
        'recommended' => 'موصى بها',
        'this_free_plan' => 'هذه باقه مجانية',
        'is_visible' => 'مرئي?',
        'visible_help' => '<br/>هل الباقه مرئية في جدول التسعير؟',
        'description' => 'الوصف',
        'free_plan' => 'باقه مجانية',
        'gateway_status' => 'حالة بوابة الباقه',
        'code' => 'كود',
        'code_help' => 'معرف فريد لهذه الباقه ، والذي سيتم استخدامه لباقه الاشتراك عن بُعد إذا لزم الأمر.
مثلا باقه الشريط سيتم إنشاؤه إذا لم يكن موجودا                       ',
        'create_gateway_plan' => 'إنشاء هذه الباقه على البوابة',
        'bill_frequency' => 'تكرار',
        'bill_cycle_every' => 'كل',
        'every_options' => [
            'week' => 'أسبوع (s)',
            'month' => '(s) الشهور',
            'year' => 'السنوات (s)'
        ],
        'trial_period' => 'الفترة التجريبية',
        'period_help' => 'عدد الأيام للعملاء الجدد في هذه الباقه يجب أن يحصلوا على نسخة تجريبية مجانية.',
    ],
    'product' => [
        'image' => 'الصورة',
        'name' => 'الاسم',
        'short_code' => 'رمز قصير',
        'description' => 'الوصف',
        'require_shipping_address' => 'يتطلب عنوان الشحن عند الاشتراك',
        'clear' => 'مسح الصورة الحالية.'
    ],
    'subscription' => [
        'subscription_reference' => 'المرجع',
        'sub_reference' => 'مرجع الاشتراك',
        'product_id' => 'المنتج',
        'gateway' => 'طريقة الدفع',
        'subscription_statuses' => [
            'active' => 'نشط',
            'cancelled' => 'ألغيت',
            'pending' => 'قيد الانتظار'
        ],
        'plan_id' => 'باقه',
        'user_id' => 'مستخدم',
        'trial_ends_at' => 'تنتهي التجربة في',
        'ends_at' => 'ينتهي عند',
        'on_trial' => 'قيد التجربة',
        'description' => 'الوصف',
        'grace_period' => 'فترة الانتظار',
        'pricing' => 'الأسعار',
        'select_payment_method' => 'يرجى اختيار طريقة الدفع',
        'next_billing_at' => 'الفواتير القادمة في',
    ]


];