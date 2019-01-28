<?php

/**
 * SecurionPay Create Subscription Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Create Subscription Request
 *
 * @see \Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api/php#create_subscription
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
        return $this->endpoint . '/charges/' . $this->getInvoiceReference() . '/capture';
    }
}
