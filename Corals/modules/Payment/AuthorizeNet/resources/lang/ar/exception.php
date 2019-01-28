<?php

return [

    'request_not_contain_header' => 'لم يتضمن الطلب عنوانًا باسم "AuthorizedNet-Signature".',
    'signature_found_header_name' => 'التوقيع: name: الموجود في العنوان المسمى `AuthorizeNet-Signature` غير صالح. تأكد من أن `services.AuthorizeNet.webhook_signing_secret`
يتم تعيين مفتاح التهيئة على القيمة التي عثرت عليها في لوحة بيانات AuthorizeNet. إذا كنت تقوم بالتخزين المؤقت للتهيئة ، فحاول تشغيل `php artisan clear: cache` لحل المشكلة.                                 ',

    'authorize_webhook_sing_secret' => 'لم يتم تعيين سر توقيع AuthoredNet webhook. تأكد من تكوين `AuthorizeNet.settings` على النحو المطلوب.',
    'invalid_authorize_payload' => 'حمولة AuthorizeNet غير صالحة يرجى التحقق من WebhookCall: :arg',
    'invalid_authorize_invoice_code' => 'رمز AuthorizeNet غير صالح   يرجى التحقق من  WebhookCall: :arg',
    'invalid_authorize_subscription_Reference' => 'مرجع الاشتراك AuthorizeNet غير صالح. يرجى التحقق من WebhookCall: :arg',
    'invalid_authorize_customer' => 'عميل AuthorizeNet غير صالح . يرجى التحقق من  WebhookCall: :arg',
    'invalid_request_exception_specify_amount' => 'يرجى تحديد كمية كسلسلة أو فلوت، مع المنازل العشرية (e.g.10.00 لتمثيل $ 10.00)',


];