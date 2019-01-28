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
class PayInvoiceRequest extends AbstractRequest
{
    public function getInvoiceReference()
    {
        return $this->getParameter('invoiceReference');
    }

    public function setInvoiceReference($value)
    {
        return $this->setParameter('invoiceReference', $value);
    }

    public function getData()
    {
        $this->validate('invoiceReference');

        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/invoices/' . $this->getInvoiceReference() . '/pay';
    }
}
