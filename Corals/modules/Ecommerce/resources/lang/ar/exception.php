<?php

return [
    'coupon' => [
        'not_eligible_use_coupon' => 'لست مؤهلاً لاستخدام رمز القسيمة هذا',
        'code_reached_maximum' => 'بلغ رمز القسيمة الحد الأقصى لاستخدامه',
        'must_least_total' => 'يجب أن يكون لديك ما لا يقل عن مجموعه :amount',
        'max_discount_amount' => 'له خصم كحد أقصى من :amount',
        'coupon_not_available' => 'هذه القسيمة غير متوفرة',
        'must_use_discount_amount' => 'يجب عليك استخدام مبلغ الخصم.',
    ],
    'cart' => [
        'not_find_relation' => 'لا يمكن العثور على نموذج العلاقة',
        'not_find model' => 'تعذر العثور على نموذج العنصر لـ :arg',
        'item_limited_per_order' => 'هذا البند يقتصر على :quantity العناصر لكل طلب.',
        'quantity_valid_num' => 'يجب أن تكون الكمية رقمًا صالحًا',
        'price_must_valid_num' => 'يجب أن يكون السعر رقمًا صالحًا',
        'tax_must_number' => 'يجب أن تكون الضريبة رقمًا',
        'taxable_option_must_boolean' => 'يجب أن يكون الخيار الخاضع للضريبة منطقيًا',

    ],
    'misc' => [
        'invalid_gateway' => 'تكوين العبّارة غير صالح',
        'product_code_exist' => 'المنتج مع الكود :arg موجودة في بوابة.',
        'create_gateway' => 'إنشاء منتج البوابة فشل :message',
        'update_gateway' => 'تحديث منتج البوابة فشل :message',
        'delete_product' => 'بوابة deleteProduct فشلت :message',
        'create_gateway_sku' => 'إنشاء بوابة sku فشل :message',
        'update_gateway_sku' => 'تحديث بوابة sku فشل :message',
        'delete_sku' => 'بوابة deleteSKU فشلت :message',
        'create_order_failed' => 'إنشاء أمر عبّارة فشل :message',
        'invalid_order_code' => 'رمز الطلب غير صالح :data',
        'update_gateway_order_failed' => 'تحديث أمر العبّارة فشل :message',
        'order_already_paid' => 'يتم دفع النظام بالفعل',
        'gateway_create_payment' => 'بوابة createPaymentToken فشلت:data',
        'least_should_upload' => 'يجب تحميل ملف واحد على الأقل',
    ],
    'sku' => [
        'item_has_only_quantity' => 'هذا البند لديه فقط :quantity الكمية المتاحة في الأوراق المالية',
        'item_current_out' => 'هذا المنتج نفذ',
        'invalid_custom' => 'قيمة الخيار المخصص غير صالحة'
    ],
    'checkout' => [
        'invalid_coupon' => 'رقم قسيمه غير صالح',
    ]
];