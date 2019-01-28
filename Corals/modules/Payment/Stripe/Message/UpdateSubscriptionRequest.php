<?php

/**
 * Stripe Update Subscription Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Update Subscription Request
 *
 * @see \Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#update_subscription
 */
class UpdateSubscriptionRequest extends AbstractRequest
{
    /**
     * Get the plan
     *
     * @return string
     */
    public function getPlan()
    {
        return $this->getParameter('plan');
    }

    /**
     * Set the plan
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|UpdateSubscriptionRequest
     */
    public function setPlan($value)
    {
        return $this->setParameter('plan', $value);
    }

    /**
     * @deprecated
     */
    public function getPlanId()
    {
        return $this->getPlan();
    }

    /**
     * Set the trial_end
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|UpdateSubscriptionRequest
     */
    public function setTrialEnd($value)
    {
        return $this->setParameter('trial_end', $value);
    }

    /**
     * @return mixed
     */
    public function getTrialEnd()
    {
        return $this->getParameter('trial_end');
    }

    /**
     * @deprecated
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|UpdateSubscriptionRequest
     */
    public function setPlanId($value)
    {
        return $this->setPlan($value);
    }

    /**
     * Get the subscription reference
     *
     * @return string
     */
    public function getSubscriptionReference()
    {
        return $this->getParameter('subscriptionReference');
    }

    /**
     * Set the subscription reference
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|UpdateSubscriptionRequest
     */
    public function setSubscriptionReference($value)
    {
        return $this->setParameter('subscriptionReference', $value);
    }

    public function getData()
    {
        $this->validate('customerReference', 'subscriptionReference', 'plan');

        $data = array(
            'plan' => $this->getPlan()
        );

        if ($this->parameters->has('tax_percent')) {
            $data['tax_percent'] = (float)$this->getParameter('tax_percent');
        }

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        if ($this->parameters->has('trial_end')) {
            $data['trial_end'] = $this->getParameter('trial_end');
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/customers/' . $this->getCustomerReference()
            . '/subscriptions/' . $this->getSubscriptionReference();
    }
}
