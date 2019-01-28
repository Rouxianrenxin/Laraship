<?php

/**
 * Stripe Create Subscription Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Create Subscription Request
 *
 * @see \Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api/php#create_subscription
 */
class CreateInvoiceRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('customerReference');

        $data = array(
            'customer' => $this->getCustomerReference()
        );

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/invoices';
    }
}
