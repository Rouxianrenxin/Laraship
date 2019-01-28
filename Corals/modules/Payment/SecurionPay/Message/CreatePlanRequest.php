<?php

/**
 * SecurionPay Create Plan Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Create Plan Request
 *
 * @see \Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api#create_plan
 */
class CreatePlanRequest extends AbstractRequest
{
    /**
     * Set the plan amount
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setAmount($planAmount)
    {
        return $this->setParameter('amount', $planAmount);
    }

    /**
     * Get the plan amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * Set the plan currency
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setCurrency($planCurrency)
    {
        return $this->setParameter('currency', $planCurrency);
    }

    /**
     * Get the plan currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * Set the plan interval
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setInterval($planInterval)
    {
        return $this->setParameter('interval', $planInterval);
    }

    /**
     * Get the plan interval
     *
     * @return int
     */
    public function getInterval()
    {
        return $this->getParameter('interval');
    }

    /**
     * Set the plan interval count
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setIntervalCount($planIntervalCount)
    {
        return $this->setParameter('intervalCount', $planIntervalCount);
    }

    /**
     * Get the plan interval count
     *
     * @return int
     */
    public function getIntervalCount()
    {
        return $this->getParameter('intervalCount');
    }


    /**
     * Set the plan billing Cycles
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setBillingCycles($billingCycles)
    {
        return $this->setParameter('billingCycles', $billingCycles);
    }

    /**
     * Get the plan interval count
     *
     * @return int
     */
    public function getBillingCycles()
    {
        return $this->getParameter('billingCycles');
    }


    /**
     * Set the plan  Recurs To
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setRecursTo($recursTo)
    {
        return $this->setParameter('recursTo', $recursTo);
    }

    /**
     * Get the plan Recurs To
     *
     * @return int
     */
    public function getRecursTo()
    {
        return $this->getParameter('recursTo');
    }


    /**
     * Set the plan name
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setName($planName)
    {
        return $this->setParameter('name', $planName);
    }


    /**
     * Get the plan name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getParameter('name');
    }


    /**
     * Set the plan trial period days
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setTrialPeriodDays($planTrialPeriodDays)
    {
        return $this->setParameter('trialPeriodDays', $planTrialPeriodDays);
    }

    /**
     * Get the plan trial period days
     *
     * @return int
     */
    public function getTrialPeriodDays()
    {
        return $this->getParameter('trialPeriodDays');
    }

    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'interval', 'name');

        $data = array(
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'interval' => $this->getInterval(),
            'name' => $this->getName()
        );

        $metadata = $this->getMetadata();

        if ($metadata != null) {
            $data['metadata'] = $metadata;
        }

        $intervalCount = $this->getIntervalCount();

        if ($intervalCount != null) {
            $data['intervalCount'] = $intervalCount;
        }


        $trialPeriodDays = $this->getTrialPeriodDays();
        if ($trialPeriodDays != null) {
            $data['trialPeriodDays'] = $trialPeriodDays;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans';
    }
}
