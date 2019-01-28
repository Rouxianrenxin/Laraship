<?php

return [
    'request_did_not_contain' => 'لم يحتوي الطلب على رأس مسمى "TwoCheckout-Signature".',
    'signature_found_header_named' => 'التوقيع: :name الموجود في العنوان المسمى `TwoCheckout-Signature غير صالح. تأكد من أن `services.twocheckout.webhook_signing_secret`
                                         يتم تعيين مفتاح التكوين على القيمة التي وجدتها في لوحة معلومات TwoCheckout. إذا كنت تقوم بالتخزين المؤقت للتهيئة ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة',
    'stripe_secret_not_set' => 'لم يتم تعيين سر توقيع شريط TwoCheckout. تأكد من تكوين `twocheckout.settings` على النحو المطلوب.',
    'invalid_two_checked_payload' => 'غير صالح الحمولة TwoCheckout. يرجى المراجعة WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'رمز فاتورة TwoCheckout غير صالح. يرجى المراجعةWebhookCall: :arg',
    'invalid_two_checked_subscription' => 'مرجع اشتراك TwoCheckout غير صالح. يرجى المراجعة WebhookCall: :arg',
    'invalid_two_checked_customer' => 'عميل غير صالح للتسجيل يرجى المراجعة WebhookCall: :arg',


];