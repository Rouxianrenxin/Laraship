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
class CreateSubscriptionRequest extends AbstractRequest
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
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setPlan($value)
    {
        return $this->setParameter('plan', $value);
    }

    /**
     * Get the tax percent
     *
     * @return string
     */
    public function getTaxPercent()
    {
        return $this->getParameter('tax_percent');
    }

    /**
     * Set the tax percentage
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setTaxPercent($value)
    {
        return $this->setParameter('tax_percent', $value);
    }

    /**
     * Get the tax percent
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->getParameter('discount');
    }

    /**
     * Set the tax percentage
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setDiscount($value)
    {
        return $this->setParameter('discount', $value);
    }

    public function getData()
    {
        $this->validate('customerReference', 'plan');

        $data = array(
            'plan' => $this->getPlan()
        );

        if ($this->parameters->has('tax_percent')) {
            $data['tax_percent'] = (float)$this->getParameter('tax_percent');
        }
        if ($this->parameters->has('discount')) {
            $data['discount'] = (float)$this->getParameter('discount');
        }

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/customers/' . $this->getCustomerReference() . '/subscriptions';
    }
}
