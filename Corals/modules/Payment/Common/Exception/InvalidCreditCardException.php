<?php

namespace Corals\Modules\Payment\Common\Exception;

/**
 * Invalid Credit Card Exception
 *
 * Thrown when a credit card is invalid or missing required fields.
 */
class InvalidCreditCardException extends \Exception implements PaymentException
{
}
