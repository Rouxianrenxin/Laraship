<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `Omise-Signature`.',
    'signature_found_header_named' => 'The signature :name found in the header named `Omise-Signature is invalid. Make sure that the `services.omise.webhook_signing_secret` 
                                        config key is set to the value you found on the Omise dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'stripe_secret_not_set' => 'The Stripe Omise signing secret is not set. Make sure that the `omise.settings`  configured as required.',
    'invalid_two_checked_payload' => 'Invalid Omise Payload. Please check WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'Invalid Omise Invoice Code. Please check WebhookCall: :arg',
    'invalid_two_checked_subscription' => 'Invalid Omise Subscription Reference. Please check WebhookCall: :arg',
    'invalid_two_checked_customer' => 'Invalid Omise Customer. Please check WebhookCall: :arg',


];