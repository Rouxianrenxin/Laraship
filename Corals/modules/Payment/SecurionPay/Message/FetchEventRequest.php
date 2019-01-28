<?php

/**
 * SecurionPay Fetch Event Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Fetch Event Request.
 *
 * @link https://securionpay.com/docs/api/curl#retrieve_event
 */
class FetchEventRequest extends AbstractRequest
{
    /**
     * Get the event reference.
     *
     * @return string
     */
    public function getEventReference()
    {
        return $this->getParameter('eventReference');
    }

    /**
     * Set the event reference.
     *
     * @return FetchEventRequest provides a fluent interface.
     */
    public function setEventReference($value)
    {
        return $this->setParameter('eventReference', $value);
    }

    public function getData()
    {
        $this->validate('eventReference');
        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/events/' . $this->getEventReference();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
