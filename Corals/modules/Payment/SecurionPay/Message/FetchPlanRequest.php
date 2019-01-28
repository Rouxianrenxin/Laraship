<?php

/**
 * SecurionPay Fetch Plan Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Fetch Plan Request.
 *
 * @link https://securionpay.com/docs/api#retrieve_plan
 */
class FetchPlanRequest extends AbstractRequest
{
    /**
     * Get the plan id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('planId');
    }

    /**
     * Set the plan id.
     *
     * @return FetchPlanRequest provides a fluent interface.
     */
    public function setId($planId)
    {
        return $this->setParameter('planId', $planId);
    }

    public function getData()
    {
        $this->validate('planId');
        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans/' . $this->getId();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
