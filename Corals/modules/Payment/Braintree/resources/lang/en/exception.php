<?php


return [
    'request_did_not_contain_header_named' => 'The request did not contain a header named `Braintree-Signature`.',
    'the_signature_found_header_named' => 'The signature :name found in the header named `Braintree-Signature` is invalid. Make sure that the `services.braintree.webhook_signing_secret` config key is set to the value you found on the Braintree dashboard. 
            If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'braintree_webhook_sing_secret_not_set' => 'The Braintree webhook signing secret is not set. Make sure that the `braintree.settings` configured as required.',
    'invalid_braintree_payload' => 'Invalid Braintree Payload. Please check WebhookCall: :arg',
    'invalid_braintree_invoice_code' => 'Invalid Braintree Invoice Code. Please check WebhookCall: :arg',
    'invalid_braintree_subscription_reference' => 'Invalid Braintree Subscription Reference. Please check WebhookCall: :arg',
    'invalid_braintree_customer' => 'Invalid Braintree Customer. Please check WebhookCall: :arg',
    'braintree_library_requires_extension' => 'The Braintree library requires the :name extension.',
    'invalid_request_exception_specify_amount' => 'Please specify amount as a string or float, with decimal places (e.g.10.00 to represent $10.00)',
];