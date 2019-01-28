<?php


return [
    'tax' => [
        'error_calculating_tax' => 'Error Calculating Tax :message',
    ],
    'webhook' => [
        'invalid_event_name' => 'Could not process :name id webhookCall of event name :eventname not registered.',
        'missing_event_name' => 'Could not process webhook id :arg because did not contain an event name.',
        'webhook_already_mark_as_process' => 'Could not process webhook id :arg because it is already marked as processed.',
    ],
    'messages_exception_common' => [
        'invalid_response' => 'Invalid response from payment gateway',
        'request_cannot_be_modified' => 'Request cannot be modified after it has been sent!',
        'key_required' => 'The :key parameter is required',
        'amount_precision_is_too_high' => 'Amount precision is too high for currency.',
        'negative_amount_is_not_allowed' => 'negative amount is not allowed.',
        'zero_amount_is_not_allowed' => 'A zero amount is not allowed.',
        'must_call_send' => 'You must call send() before accessing the Response!',
        'response_does_not_support' => 'This response does not support redirection.',
        'url_cannot_be_empty' => 'The given redirectUrl cannot be empty.',
        'invalid_redirect_data' => 'Invalid redirect method :data',
        'val_require' => 'The :val is required',
        'card_has_expired' => 'Card has expired',
        'card_should_digits' => 'Card number should have 12 to 19 digits',
        'class_not_found' => 'Class :class not found',
        'data_not_valid' => 'Data type is not a valid decimal number.',
        'string_not_valid' => 'String is not a valid decimal number.',
    ],
    'payment_service' => [
        'error_load_module' => 'There was an error when loading module: :code module has been disabled',
    ]
];