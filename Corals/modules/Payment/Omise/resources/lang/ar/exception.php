<?php

return [
    'request_did_not_contain' => 'لم يحتوي الطلب على رأس مسمى "Omise-Signature".',
    'signature_found_header_named' => 'التوقيع: :name الموجود في العنوان المسمى `Omise-Signature غير صالح. تأكد من أن `services.omise.webhook_signing_secret`
                                         يتم تعيين مفتاح التكوين على القيمة التي وجدتها في لوحة معلومات Omise. إذا كنت تقوم بالتخزين المؤقت للتهيئة ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة',
    'stripe_secret_not_set' => 'لم يتم تعيين سر توقيع شريط Omise. تأكد من تكوين `omise.settings` على النحو المطلوب.',
    'invalid_two_checked_payload' => 'غير صالح الحمولة Omise. يرجى المراجعة WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'رمز فاتورة Omise غير صالح. يرجى المراجعةWebhookCall: :arg',
    'invalid_two_checked_subscription' => 'مرجع اشتراك Omise غير صالح. يرجى المراجعة WebhookCall: :arg',
    'invalid_two_checked_customer' => 'عميل غير صالح للتسجيل يرجى المراجعة WebhookCall: :arg',


];