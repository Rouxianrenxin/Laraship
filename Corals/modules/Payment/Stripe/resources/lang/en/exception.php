<?php

return [
    'request_did_not_contain' => 'The request did not contain a header named `Stripe-Signature`.',
    'signature_found_header_named' => 'The signature :name found in the header named `Stripe-Signature` is invalid. Make sure that the `services.stripe.webhook_signing_secret` config key is set to the value you found on the Stripe dashboard. 
                                    If you are caching your config try running `php artisan clear:cache` to resolve the problem.',

    'stripe_secret_not_set' => 'The Stripe webhook signing secret is not set. Make sure that the `stripe.settings` configured as required.',

    'invalid_stripe_payload' => 'Invalid Stripe Payload. Please check WebhookCall: :arg',
    'invalid_stripe_invoice' => 'Invalid Stripe Invoice Code. Please check WebhookCall: :arg',
    'invalid_stripe_subscription' => 'Invalid Stripe Subscription Reference. Please check WebhookCall: :arg',
    'invalid_stripe_customer' => 'Invalid Stripe Customer. Please check WebhookCall: :arg',
    'source_transaction_required' => 'The sourceTransaction or transferGroup parameter is required',
    'amount_is_too_high' => 'Amount precision is too high for currency.',
    'negative_not_allowed' => 'A negative amount is not allowed.',
    'zero_amount_not_allowed' => 'A zero amount is not allowed.',
    'must_pass_card' => 'You must pass either the card or the customer',

];