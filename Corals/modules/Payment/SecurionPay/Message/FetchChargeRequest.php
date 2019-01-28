<?php

/**
 * SecurionPay Fetch Charge Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Fetch Charge Request.
 *
 * @deprecated 2.3.3:3.0.0 functionality provided by \Corals\Modules\Payment\SecurionPay\Message\FetchTransactionRequest
 * @see \Corals\Modules\Payment\SecurionPay\Message\FetchTransactionRequest
 * @link https://securionpay.com/docs/api#retrieve_charge
 */
class FetchChargeRequest extends AbstractRequest
{
    /**
     * Get the charge reference.
     *
     * @return string
     */
    public function getChargeReference()
    {
        return $this->getParameter('chargeReference');
    }

    /**
     * Set the charge reference.
     *
     * @param string
     * @return FetchChargeRequest provides a fluent interface.
     */
    public function setChargeReference($value)
    {
        return $this->setParameter('chargeReference', $value);
    }

    public function getData()
    {
        $this->validate('chargeReference');
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/charges/' . $this->getChargeReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
