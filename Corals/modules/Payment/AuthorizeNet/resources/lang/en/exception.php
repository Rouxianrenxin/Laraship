<?php

return [

    'request_not_contain_header' => 'The request did not contain a header named `AuthorizeNet-Signature`.',
    'signature_found_header_name' => 'The signature :name found in the header named `AuthorizeNet-Signature` is invalid. Make sure that the `services.AuthorizeNet.webhook_signing_secret` 
                                      config key is set to the value you found on the AuthorizeNet dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',

    'authorize_webhook_sing_secret' => 'The AuthorizeNet webhook signing secret is not set. Make sure that the `AuthorizeNet.settings` configured as required.',
    'invalid_authorize_payload' => 'Invalid AuthorizeNet Payload. Please check WebhookCall: :arg',
    'invalid_authorize_invoice_code' => 'Invalid AuthorizeNet Invoice Code. Please check WebhookCall: :arg',
    'invalid_authorize_subscription_Reference' => 'Invalid AuthorizeNet Subscription Reference. Please check WebhookCall: :arg',
    'invalid_authorize_customer' => 'Invalid AuthorizeNet Customer. Please check WebhookCall: :arg',
    'invalid_request_exception_specify_amount' => 'Please specify amount as a string or float, with decimal places (e.g.10.00 to represent $10.00)',
];