<?php

return [
    'request_did_not_contain' => 'لم يحتوي الطلب على رأس مسمى `Stripe-Signature`.',
    'signature_found_header_named' => 'التوقيع: name: الموجود في الرأس المسمى` Stripe-Signature` غير صالح. تأكد من تعيين مفتاح config `services.stripe.webhook_signing_secret` على القيمة التي عثرت عليها في لوحة تحكم Stripe.
                                     إذا كنت تقوم بالتخزين المؤقت للتهيئة ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة.',

    'stripe_secret_not_set' => 'لم يتم تعيين توقيع سر الشريط webhook. تأكد من تهيئة `stripe.settings` على النحو المطلوب.',

    'invalid_stripe_payload' => 'حمولة Stripe غير صالحة يرجى التحقق منWebhookCall:  :arg',
    'invalid_stripe_invoice' => 'رمز فاتورة شريط غير صالح. يرجى التحقق من WebhookCall: :arg',
    'invalid_stripe_subscription' => 'مرجع اشتراك الشريط غير صالح يرجى التحقق من  WebhookCall: :arg',
    'invalid_stripe_customer' => 'عميل Stripe غير صالح يرجى التحقق من  WebhookCall: :arg',
    'source_transaction_required' => 'مطلوب المصدر sourceTransaction أو transferGroup',
    'amount_is_too_high' => 'كمية دقة عالية جدا للعملة.',
    'negative_not_allowed' => 'مبلغ سلبي غير مسموح به.',
    'zero_amount_not_allowed' => 'مبلغ الصفر غير مسموح به.',
    'must_pass_card' => 'يجب أن تمر إما البطاقة أو العميل',

];