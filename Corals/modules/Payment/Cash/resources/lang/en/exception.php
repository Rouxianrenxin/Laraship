<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `Cash-Signature`.',
    'the_signature_found_header_name' => 'The signature :name found in the header named `Cash-Signature` is invalid. Make sure that 
            the `services.Cash.webhook_signing_secret` config key is set to the value you found on the Cash dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'cash_sign_secret_not_set' => 'The Cash webhook signing secret is not set. Make sure that the `Cash.settings` configured as required.',
    'invalid_cash_payload' => 'Invalid Cash Payload. Please check WebhookCall: :arg',
    'invalid_cash_invoice_code' => 'Invalid Cash Invoice Code. Please check WebhookCall: :arg',
    'invalid_cash_subscription' => 'Invalid Cash Subscription Reference. Please check WebhookCall: :arg',
    'invalid_cash_customer' => 'Invalid Cash Customer. Please check WebhookCall: :arg',
    'please_specify_amount_string' => 'Please specify amount as a string or float,.
             with decimal places (e.g. 10.00 to represent $10.00).',
];