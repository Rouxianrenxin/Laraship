<?php


return [
    'advertiser' => [
        'name' => 'الاسم',
        'contact' => 'التواصل',
        'email' => 'الايميل',
        'notes' => 'ملاحظات',
    ],
    'banner' => [
        'name' => 'الاسم',
        'campaign' => 'حملة',
        'dimension' => 'البعد',
        'type' => 'النوع',
        'type_options' => [
            'script' => 'النصي',
            'media' => 'وسائل الاعلام',
            'link' => 'الرابط'
        ],
        'weight' => 'الوزن',
        'notes' => 'ملاحظات',
        'url' => 'عنوان الرابط',

    ],
    'campaign' => [
        'name' => 'الاسم',
        'advertiser' => 'المعلن',
        'starts_at' => 'يبدأ في',
        'ends_at' => 'ينتهي في',
        'ends_at_help' => 'اذا لم بتم تحديد تاريخ الانتهاء لن تنتهي',
        'notes' => 'ملاحظات',
        'weight' => 'الوزن',
        'limit_type' => 'نوع الحد',
        'limit_type_options' => [
            'impressions' => 'الانطباعات',
            'clicks' => 'الضغطات'
        ],
        'limit_per_day' => 'حد لكل يوم',
        'limit_per_day_help' => '*مطلوب في حالة تحديد نوع الحد',
    ],
    'impression' => [
        'banner_id' => 'شعار',
        'zone_id' => 'منطقة',
        'session_id' => 'جلسة',
        'page_slug' => 'رابط',
        'clicked' => 'النقر عليها',
        'visitor_details' => 'التفاصيل',
    ],
    'website' => [
        'name' => 'الاسم',
        'url' => 'عنوان الرابط الالكتروني',
        'contact' => 'الاتصال',
        'email' => 'البريد الالكتروني',
        'notes' => 'الملاحظات',
    ],
    'zone' => [
        'name' => 'الاسم',
        'website' => 'الموقع الالكتروني',
        'key' => 'المفتاح',
        'dimension' => 'بعد',
        'notes' => 'ملاحظات',
        'banner' => 'الاعلانات',
        'embed_code' => 'تضمين الكود',
    ]
];