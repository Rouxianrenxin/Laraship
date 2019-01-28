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
class CreateSubscriptionRequest extends AbstractRequest
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


    /**
     * Get the Trial End
     *
     * @return Timestamp
     */
    public function getTrialEnd()
    {
        return $this->getParameter('trialEnd');
    }

    /**
     * Set the Trial End
     *
     * @param $value
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setTrialEnd($value)
    {
        return $this->setParameter('trialEnd', $value);
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


    public function getData()
    {
        $this->validate('customerReference', 'planId');

        $data = array(
            'customerId' => $this->getCustomerReference(),
            'planId' => $this->getPlanId()
        );


        if ($this->parameters->has('tax_percent')) {
            $data['tax_percent'] = (float)$this->getParameter('tax_percent');
        }

        if ($this->getCaptureCharges()) {
            $data['captureCharges'] = $this->getItems();
        }

        if ($this->getTrialEnd()) {
            $data['trialEnd'] = $this->getItems();
        }

        if ($this->getQuantity()) {
            $data['quantity'] = $this->getItems();
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
