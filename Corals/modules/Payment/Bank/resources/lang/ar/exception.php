<?php

return [
    'request_did_not_contain' => 'لم يحتوي الطلب على عنوان مسمى "توقيع المصرف.',
    'the_signature_found_header_name' => 'التوقيع: name: الموجود في العنوان المسمى `Bank-Signature` غير صالح. تأكد من أن
يتم تعيين مفتاح config `services.Bank.webhook_signing_secret` على القيمة التي عثرت عليها في لوحة معلومات البنك. إذا كنت تقوم بالتخزين المؤقت للتهيئة الخاصة بك ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة. \'،',
    'bank_sign_secret_not_set' => 'لم يتم تعيين سر توقيع البنك webhook. تأكد من تهيئة `Bank.settings` على النحو المطلوب.',
    'invalid_bank_payload' => 'حمولة البنك غير صالح. يرجى التحقق من WebhookCall: :arg',
    'invalid_bank_invoice_code' => 'رمز فاتورة البنك غير صالح. يرجى التحقق من WebhookCall: :arg',
    'invalid_bank_subscription' => 'مرجع اشتراك غير صالح للبنك. يرجى التحقق من WebhookCall: :arg',
    'invalid_bank_customer' => 'عميل البنك غير صالح. يرجى التحقق من WebhookCall: :arg',
    'please_specify_amount_string' => 'يرجى تحديد المبلغ كسلسلة أو تعويم مع المنازل العشرية (على سبيل المثال ، 10.00 لتمثيل $ 10.00).',
];