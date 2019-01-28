<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `Bank-Signature`.',
    'the_signature_found_header_name' => 'The signature :name found in the header named `Bank-Signature` is invalid. Make sure that 
            the `services.Bank.webhook_signing_secret` config key is set to the value you found on the Bank dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'bank_sign_secret_not_set' => 'The Bank webhook signing secret is not set. Make sure that the `Bank.settings` configured as required.',
    'invalid_bank_payload' => 'Invalid Bank Payload. Please check WebhookCall: :arg',
    'invalid_bank_invoice_code' => 'Invalid Bank Invoice Code. Please check WebhookCall: :arg',
    'invalid_bank_subscription' => 'Invalid Bank Subscription Reference. Please check WebhookCall: :arg',
    'invalid_bank_customer' => 'Invalid Bank Customer. Please check WebhookCall: :arg',
    'please_specify_amount_string' => 'Please specify amount as a string or float,.
             with decimal places (e.g. 10.00 to represent $10.00).',
];