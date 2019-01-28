<?php


return [
    'request_did_not_contain_header_named' => 'لم يتضمن الطلب عنوانًا باسم Braintree-Signature.',
    'the_signature_found_header_named' => 'التوقيع: name: الموجود في العنوان المسمى `Braintree-Signature` غير صالح. تأكد من أن `services.Braintree.webhook_signing_secret`
يتم تعيين مفتاح التهيئة على القيمة التي عثرت عليها في لوحة بيانات Braintree. إذا كنت تقوم بالتخزين المؤقت للتهيئة ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة.',

    'braintree_webhook_sing_secret_not_set' => 'لم يتم تعيين سر توقيع Braintree webhook. تأكد من تكوين `braintree.settings` على النحو المطلوب.',
    'invalid_braintree_payload' => 'حمولة Braintree غير صالحة يرجى التحقق من  WebhookCall: :arg',
    'invalid_braintree_invoice_code' => 'رمز Braintree غير صالح يرجى التحقق  من  WebhookCall: :arg',
    'invalid_braintree_subscription_reference' => 'مجمع Braintree الاشتراكي غير صالح يرجى التحقق من  WebhookCall: :arg',
    'invalid_braintree_customer' => 'عميل Invalid Braintree Customer. غير صالح سرجى التحقق من WebhookCall: :arg',
    'braintree_library_requires_extension' => 'تتطلب مكتبة Braintree ملحق :name ',
    'invalid_request_exception_specify_amount' => 'يرجى تحديد كمية كسلسلة أو فلوت، مع المنازل العشرية (e.g.10.00 لتمثيل $ 10.00)',
];