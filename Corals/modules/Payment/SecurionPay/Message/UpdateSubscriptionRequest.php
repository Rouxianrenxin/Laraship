<?php

/**
 * SecurionPay Update Subscription Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Update Subscription Request
 *
 * @see \Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api#update_subscription
 */
class UpdateSubscriptionRequest extends AbstractRequest
{
    /**
     * Get the plan
     *
     * @return string
     */
    public function getPlanId()
    {
        return $this->getParameter('planId');
    }

    /**
     * Set the plan
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setPlanId($value)
    {
        return $this->setParameter('planId', $value);
    }


    /**
     * Get the subscriptionId
     *
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->getParameter('subscriptionId');
    }

    /**
     * Set the subscriptionId
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setSubscriptionId($value)
    {
        return $this->setParameter('subscriptionId', $value);
    }


    /**
     * Get the quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->getParameter('quantity');
    }

    /**
     * Set the quantity
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setQuantity($value)
    {
        return $this->setParameter('quantity', $value);
    }

    /**
     * Set the trial_end
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|UpdateSubscriptionRequest
     */
    public function setTrialEnd($value)
    {
        return $this->setParameter('trialEnd', $value);
    }

    /**
     * @return mixed
     */
    public function getTrialEnd()
    {
        return $this->getParameter('trialEnd');
    }

    /**
     * Get the Capture Charges Flag
     *
     * @return booelan
     */
    public function getCaptureCharges()
    {
        return $this->getParameter('captureCharges');
    }

    /**
     * Set the Capture Charges
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setCaptureCharges($value)
    {
        return $this->setParameter('captureCharges', $value);
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

        $this->validate('customerReference', 'planId', 'subscriptionReference');

        $data = array(
            'planId' => $this->getPlanId(),
        );

        if ($this->parameters->has('tax_percent')) {
            $data['tax_percent'] = (float)$this->getParameter('tax_percent');
        }

        if ($this->getCaptureCharges()) {
            $data['captureCharges'] = $this->getCaptureCharges();
        }

        if ($this->getQuantity()) {
            $data['quantity'] = $this->getQuantity();
        }

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        if ($this->getTrialEnd()) {
            $data['trialEnd'] = $this->getTrialEnd();
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/customers/' . $this->getCustomerReference()
            . '/subscriptions/' . $this->getSubscriptionReference();
    }
}
