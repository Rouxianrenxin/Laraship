<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `TwoCheckout-Signature`.',
    'signature_found_header_named' => 'The signature :name found in the header named `TwoCheckout-Signature is invalid. Make sure that the `services.twocheckout.webhook_signing_secret` 
                                        config key is set to the value you found on the TwoCheckout dashboard. If you are caching your config try running `php artisan clear:cache` to resolve the problem.',
    'stripe_secret_not_set' => 'The Stripe TwoCheckout signing secret is not set. Make sure that the `twocheckout.settings`  configured as required.',
    'invalid_two_checked_payload' => 'Invalid TwoCheckout Payload. Please check WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'Invalid TwoCheckout Invoice Code. Please check WebhookCall: :arg',
    'invalid_two_checked_subscription' => 'Invalid TwoCheckout Subscription Reference. Please check WebhookCall: :arg',
    'invalid_two_checked_customer' => 'Invalid TwoCheckout Customer. Please check WebhookCall: :arg',


];