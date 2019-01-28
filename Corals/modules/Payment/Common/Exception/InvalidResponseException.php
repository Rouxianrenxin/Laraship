<?php

namespace Corals\Modules\Payment\Common\Exception;

/**
 * Invalid Response exception.
 *
 * Thrown when a gateway responded with invalid or unexpected data (for example, a security hash did not match).
 */
class InvalidResponseException extends \Exception implements PaymentException
{
    public function __construct($message = 'Payment::exception.messages_exception_common.invalid_response', $code = 0, $previous = null)
    {
        parent::__construct(trans($message), $code, $previous);
    }
}


