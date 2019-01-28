<?php

/**
 * SecurionPay Cancel Subscription Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Cancel Subscription Request.
 *
 * @see Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api/#cancel_subscription
 */
class CancelSubscriptionRequest extends AbstractRequest
{
    /**
     * Get the subscription reference.
     *
     * @return string
     */
    public function getSubscriptionReference()
    {
        return $this->getParameter('subscriptionReference');
    }

    /**
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function setSubscriptionReference($value)
    {
        return $this->setParameter('subscriptionReference', $value);
    }


    /**
     * Set whether or not to cancel the subscription at period end.
     *
     * @param bool $value
     *
     * @return CancelSubscriptionRequest provides a fluent interface.
     */
    public function setAtPeriodEnd($value)
    {
        return $this->setParameter('atPeriodEnd', $value);
    }

    /**
     * Get whether or not to cancel the subscription at period end.
     *
     * @return bool
     */
    public function getAtPeriodEnd()
    {
        return $this->getParameter('atPeriodEnd');
    }

    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('customerReference', 'subscriptionReference');

        $data = array();


        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint
            . '/customers/' . $this->getCustomerReference()
            . '/subscriptions/' . $this->getSubscriptionReference() . ($this->getAtPeriodEnd() ? '?atPeriodEnd=true' : '');
    }

    public function getHttpMethod()
    {
        return 'DELETE';
    }
}
