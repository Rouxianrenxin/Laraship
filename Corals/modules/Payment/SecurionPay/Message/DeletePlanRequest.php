<?php

/**
 * SecurionPay Delete Plan Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Delete Plan Request.
 *
 * @link https://securionpay.com/docs/api#delete_plan
 */
class DeletePlanRequest extends AbstractRequest
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
     * @return DeletePlanRequest provides a fluent interface.
     */
    public function setId($planId)
    {
        return $this->setParameter('planId', $planId);
    }

    public function getData()
    {
        $this->validate('planId');

        return;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans/' . $this->getId();
    }

    public function getHttpMethod()
    {
        return 'DELETE';
    }
}
