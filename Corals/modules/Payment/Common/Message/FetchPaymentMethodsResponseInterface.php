<?php
/**
 * Fetch Payment Methods Response interface
 */

namespace Corals\Modules\Payment\Common\Message;

/**
 * Fetch Payment Methods Response interface
 *
 * This interface class defines the functionality of a response
 * that is a "fetch payment method" response.  It extends the ResponseInterface
 * interface class with some extra functions relating to the
 * specifics of a response to fetch the payment method from the gateway.
 * This happens when the gateway needs the customer to choose a
 * payment method.
 *
 * @see ResponseInterface
 * @see Corals\Modules\Payment\Common\PaymentMethod
 */
interface FetchPaymentMethodsResponseInterface extends ResponseInterface
{
    /**
     * Get the returned list of payment methods.
     *
     * These represent separate payment methods which the user must choose between.
     *
     * @return \Corals\Modules\Payment\Common\PaymentMethod[]
     */
    public function getPaymentMethods();
}
