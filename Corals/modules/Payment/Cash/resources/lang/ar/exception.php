<?php

return [
    'request_did_not_contain' => 'لم يحتوي الطلب على عنوان مسمى "توقيع المصرف.',
    'the_signature_found_header_name' => 'التوقيع: name: الموجود في العنوان المسمى `Cash-Signature` غير صالح. تأكد من أن
يتم تعيين مفتاح config `services.Cash.webhook_signing_secret` على القيمة التي عثرت عليها في لوحة معلومات البنك. إذا كنت تقوم بالتخزين المؤقت للتهيئة الخاصة بك ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة. \'،',
    'cash_sign_secret_not_set' => 'لم يتم تعيين سر توقيع البنك webhook. تأكد من تهيئة `Cash.settings` على النحو المطلوب.',
    'invalid_cash_payload' => 'حمولة البنك غير صالح. يرجى التحقق من WebhookCall: :arg',
    'invalid_cash_invoice_code' => 'رمز فاتورة البنك غير صالح. يرجى التحقق من WebhookCall: :arg',
    'invalid_cash_subscription' => 'مرجع اشتراك غير صالح للبنك. يرجى التحقق من WebhookCall: :arg',
    'invalid_cash_customer' => 'عميل البنك غير صالح. يرجى التحقق من WebhookCall: :arg',
    'please_specify_amount_string' => 'يرجى تحديد المبلغ كسلسلة أو تعويم مع المنازل العشرية (على سبيل المثال ، 10.00 لتمثيل $ 10.00).',
];