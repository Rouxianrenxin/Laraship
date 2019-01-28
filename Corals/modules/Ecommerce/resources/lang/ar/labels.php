<?php

return [
    'settings' => [
        'company' => [
            'owner' => 'المالك',
            'name' => 'الاسم',
            'street' => 'الشارع الأول',
            'city' => 'المدينة',
            'state' => 'الحالة',
            'zip' => 'الرمز البريدي',
            'country' => 'البلد',
            'phone' => 'التلفون',
            'email' => 'الايميل',
        ],
        'shipping' => [
            'weight_unit' => 'وحدة الوزن',
            'dimensions_unit' => 'وحدة الأبعاد',
            'shippo_live_token' => 'برنامج Shippo Live Token',
            'shippo_test_token' => 'Shippo رمز اختبار',
            'shippo_sandbox_mode' => 'Shippo الوضع التجريبي',
            'select_method' => 'يرجى تحديد طريقة الشحن',
            'no_available_shipping' => 'عذرا لا يوجد طرق الشحن المتاحة',


        ],
        'tax' => [
            'calculate_tax' => 'تمكين حساب الضرائب',

        ],
        'rating' => [
            'enable' => 'تمكين التقييم',
        ],
        'wishlist' => [
            'enable' => 'تمكين قائمة الامنيات',
        ],
        'appearance' => [
            'page_limit' => 'حد صفحة المتجر',
        ],
        'search' => [
            'title_weight' => 'وزن العنوان',
            'content_weight' => 'وزن المحتوى',
            'enable_wildcards' => 'تمكين بحث حرف البدل',
        ],
        'additonal_charge' => [
            'title' => 'العنوان',
            'amount' => 'القيمه',
            'type' => 'النوع',
            'gateways' => 'تطبيق على طرق الدفع ',

        ]
    ],
    'cart' => [
        'item_has_been_update' => 'تم تحديث كمية البند',
        'item_has_been_delete' => 'تم حذف العنصر من سلة التسوق',
        'cart_empty' => 'سلة التسوق الخاصة بك فارغة الآن',
        'product_has_been_add' => 'تمت إضافة المنتج إلى سلة التسوق بنجاح',
        'product' => 'المنتج',
        'quantity' => 'الكمية',
        'price' => 'سعر',
        'sub_total' => 'حاصل الجمع',
        'continue_shop' => 'مواصلة التسوق',
        'proceed_checkout' => 'اكمال عملية الشراء',
        'empty_cart' => 'سلة فارغة',
        'no_item_in_shopping' => 'لا يوجد لديك اي منتجات في سلة التسوق الخاصة بك',
        'have_coupon' => 'هل لديك قسيمة?',
    ],
    'product' => [
        'add_success' => 'تم اضافة تعليقك بنجاح',
        'image_upload' => 'تم تحميل الصورة بنجاح',
        'option_cannot_global' => 'لا يمكن أن تكون الخيارات عالمية ومتغيرة في نفس الوقت',
        'variations' => '<i class="fa fa-fw fa-sliders"></i> الاختلافات',
        'category' => 'فئات المنتجات',
        'file' => 'الملف',
        'description' => 'الوصف',
        'add_download' => 'انقر لإضافة تنزيل جديد.',
        'variation_option' => 'خيارات الاختلاف',
        'caption' => 'شرح',
        'more' => 'المزيد &rightarrow;'
    ],
    'checkout' => [
        'please_enter_payment' => 'يرجى إدخال تفاصيل الدفع',
        'title' => 'عنوان وصول الفواتير',
        'save_billing' => 'حفظ عنوان الفواتير لملفي الشخصي',
        'copy_billing' => 'قم بنسخ عنوان إرسال الفواتير إلى عنوان الشحن',
        'save_shipping' => 'حفظ عنوان الشحن إلى ملف التعريف الخاص بي',
        'shipping_title' => 'عنوان الشحن ',
        'title_checkout' => ' تفاصيل المحاسبه',
        'cart_detail' => 'سلة التسوق',
        'address_checkout' => 'عنوان Checkout',
        'select_shipping' => 'أختار الشحن',
        'select_payment' => 'اختر الدفع',
        'enter_payment' => 'أدخل تفاصيل الدفع',
        'order_review' => 'مراجعة الطلب',
        'sub_total' => 'حاصل الجمع',
        'tax' => 'ضريبة',
        'discount' => 'خصم',
        'total' => 'مجموعك',
        'complete_order' => '<i class="fa fa-cart"></i> اكمل الطلب ',
    ],
    'attribute' => [
        'order' => 'طلب',
        'value' => 'القيمة',
        'display' => 'عرض',
        'add_new_option' => ' انقر لإضافة خيار جديد.'
    ],
    'mail' => [
        'amount' => 'قيمة',
        'qt' => 'الكميه',
        'description' => 'الوصف',
        'sku' => 'SKU#',
        'type' => 'النوع',
        'total' => 'المجموع الكلي',
        'download' => 'للتحميل',
        'file' => 'ملف',
        'premium_content' => 'صفحات محتوى متميزة',
        'bill_address' => 'عنوان وصول الفواتير',
        'address_one' => 'العنوان الأول',
        'address_two' => 'العنوان الثاني',
        'city' => 'المدينة',
        'state' => 'الحالة',
        'zip' => 'الرمز البريدي',
        'country' => 'البلد',
        'shipping_details' => 'تفاصيل الشحن',
        'tracking_num' => ' أرقام التتبع',
        'tracking_label' => 'تتبع العلامة',
        'click_here' => 'اضغط هنا'
    ],
    'order' => [
        'download' => 'التنزيلات',
        'success' => 'نجاح',
        'order_has_been_placed' => 'لقد تم تسديد قيمة طلبك بنجاح',
        'go_to_my_order' => 'استعرض طلباتي',
        'order_detail' => 'تفاصيل الطلب',
        'update_order' => 'تحديث الطلب',
        'my_download' => 'تنزيلاتي',
        'my_order' => 'طلباتي',
        'private_page' => 'صفحاتي الخاصة',
        'title' => 'الطلبات',
        'billing_add' => 'عنوان وصول الفواتير',
        'click_here' => 'اضغط هنا ',
        'shipping_details' => 'تفاصيل الشحن',
        'tracking_num' => ' كود تتبع الشحن',
        'tracking_label' => 'ليبل تتبع العلامة',
        'file' => 'ملف',
        'description' => 'وصف',
        'download_able' => 'للتحميل',
        'private_access' => 'صفحات خاصة الوصول',
        'magic' => '<i class="fa fa-magic"></i> :title',
        'desc' => 'التفاصيل',
        'date' => 'التاريخ',
        'loc' => 'موقعك',
        'history' => 'التاريخ',
        'no_track' => 'لا تتوفر معلومات تتبع الشحن',
    ],
    'shipping' => [
        'pending' => 'قيد الانتظار',
        'expired' => 'منتهية الصلاحية',
        'place_holder' => 'كل البلدان',
    ],
    'shop' => [
        'title' => 'التسوق',
        'my_orders' => 'طلباتي',
        'buy' => 'شراء المنتج',
        'add' => 'أضف إلى السلة',
        'out_stock' => ' إنتهى من المخزن',
        'add_cart' => '<i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i> أضف إلى السلة',
        'no_setting_found' => 'لم يتم العثور على إعدادات.',
        'search' => 'ابحث ...',
        'search_results_for' => 'نتائج البحث عن  :search '


    ],
    'sku' => [
        'index_title' => '[:name] :title'
    ],
    'widget' => [
        'coupon' => 'الكوبونات',
        'products_by_brand' => 'المنتجات لكل علامه تجاريه',
        'my_download' => 'تنزيلاتي',
        'my_order' => 'طلباتي',
        'private_page' => 'صفحاتي الخاصة',
        'my_wishlist' => ' قائمتي المفضله',
        'orders' => 'الطلبات',
        'product_categories' => 'فئات المنتجات',
        'product' => 'منتجات'
    ]
];