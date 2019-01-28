<?php


return [
    'tax' => [
        'error_calculating_tax' => 'خطأ في حساب الضرائب :message',
    ],
    'webhook' => [

        'invalid_event_name' => 'لا يمكن أن العملية :eventname: webhookCall من name: eventname غير مسجل.',
        'missing_event_name' => 'تعذر معالجة معرف webhook arg: نظرًا لعدم احتوائه على اسم حدث.',
        'webhook_already_mark_as_process' => 'تعذر معالجة معرف الويب :arg نظرًا لأنه تم وضع علامة عليه بالفعل على أنه تمت معالجته.',

    ],

    'messages_exception_common' => [
        'invalid_response' => 'ستجابة غير صالحة من بوابة الدفع',
        'request_cannot_be_modified' => 'لا يمكن تعديل الطلب بعد إرساله!',
        'key_required' => 'key: المفتاح الرئيس مطلوب',
        'amount_precision_is_too_high' => 'كمية دقة عالية جدا للعملة.',
        'negative_amount_is_not_allowed' => 'المبلغ السلبي غير مسموح به.',
        'zero_amount_is_not_allowed' => 'مبلغ الصفر غير مسموح به.',
        'must_call_send' => 'يجب عليك الاتصال send () قبل الوصول إلى الاستجابة!',
        'response_does_not_support' => 'هذه الاستجابة لا تدعم إعادة التوجيه.',
        'url_cannot_be_empty' => 'لا يمكن أن يكون redirectUrl المحدد فارغًا.',
        'invalid_redirect_data' => 'طريقة إعادة التوجيه غير صالحة :date',
        'val_require' => 'المتغير مطلوب :val',
        'card_has_expired' => 'انتهت صلاحية البطاقة',
        'card_should_digits' => 'يجب أن يتكون رقم البطاقة من 12 إلى 19 رقمًا',
        'class_not_found' => 'لم يتم العثور على :class',
        'data_not_valid' => 'نوع البيانات ليس رقمًا عشريًا صالحًا.',
        'string_not_valid' => 'السلسلة ليست رقمًا عشريًا صالحًا.',
    ],
    'payment_service' => [
        'error_load_module' => 'حدث خطأ عند تحميل الوحدة :code تم تعطيل وحدة التعليمات البرمجية',
    ]
];