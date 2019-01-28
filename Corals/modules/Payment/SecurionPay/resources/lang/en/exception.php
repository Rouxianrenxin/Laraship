<?php

return [
    'invalid_securionpay_payload' => 'Invalid SecurionPay Payload. Please check WebhookCall: :arg',
    'invalid_securionpay_invoice' => 'Invalid SecurionPay Invoice Code. Please check WebhookCall: :arg',
    'invalid_securionpay_subscription' => 'Invalid SecurionPay Subscription Reference. Please check WebhookCall: :arg',
    'invalid_securionpay_customer' => 'Invalid SecurionPay Customer. Please check WebhookCall: :arg',
    'source_transaction_required' => 'The sourceTransaction or transferGroup parameter is required',
    'amount_is_too_high' => 'Amount precision is too high for currency.',
    'negative_not_allowed' => 'A negative amount is not allowed.',
    'zero_amount_not_allowed' => 'A zero amount is not allowed.',
    'must_pass_card' => 'You must pass either the card or the customer',
    'plan_has_no_mapping' => 'Plan : :name has no mapping inside gateway status',
];