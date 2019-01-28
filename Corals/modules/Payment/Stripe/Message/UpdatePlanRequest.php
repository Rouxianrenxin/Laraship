<?php

/**
 * Stripe Update Customer Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Update Customer Request.
 *
 * Customer objects allow you to perform recurring charges and
 * track multiple charges that are associated with the same customer.
 * The API allows you to create, delete, and update your customers.
 * You can retrieve individual customers as well as a list of all of
 * your customers.
 *
 * This request updates the specified customer by setting the values
 * of the parameters passed. Any parameters not provided will be left
 * unchanged. For example, if you pass the card parameter, that becomes
 * the customer's active card to be used for all charges in the future,
 * and the customer email address is updated to the email address
 * on the card. When you update a customer to a new valid card: for
 * each of the customer's current subscriptions, if the subscription
 * is in the `past_due` state, then the latest unpaid, unclosed
 * invoice for the subscription will be retried (note that this retry
 * will not count as an automatic retry, and will not affect the next
 * regularly scheduled payment for the invoice). (Note also that no
 * invoices pertaining to subscriptions in the `unpaid` state, or
 * invoices pertaining to canceled subscriptions, will be retried as
 * a result of updating the customer's card.)
 *
 * This request accepts mostly the same arguments as the customer
 * creation call.
 *
 * @link https://stripe.com/docs/api#update_customer
 */
class UpdatePlanRequest extends AbstractRequest
{
    /**
     * Set the plan ID
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setId($planId)
    {
        return $this->setParameter('id', $planId);
    }

    /**
     * Get the plan ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('id');
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
     * Set the plan statement descriptor
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setStatementDescriptor($planStatementDescriptor)
    {
        return $this->setParameter('statement_descriptor', $planStatementDescriptor);
    }

    /**
     * Get the plan statement descriptor
     *
     * @return string
     */
    public function getStatementDescriptor()
    {
        return $this->getParameter('statement_descriptor');
    }

    /**
     * Set the plan trial period days
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setTrialPeriodDays($planTrialPeriodDays)
    {
        return $this->setParameter('trial_period_days', $planTrialPeriodDays);
    }

    /**
     * Get the plan trial period days
     *
     * @return int
     */
    public function getTrialPeriodDays()
    {
        return $this->getParameter('trial_period_days');
    }

    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('id', 'name');
        $data = array();

        $name = $this->getName();

        if ($name != null) {
            $data['name'] = $name;
        }

        $statementDescriptor = $this->getStatementDescriptor();

        if ($statementDescriptor != null) {
            $data['statement_descriptor'] = $statementDescriptor;
        }

        $trialPeriodDays = $this->getTrialPeriodDays();

        if ($trialPeriodDays != null) {
            $data['trial_period_days'] = $trialPeriodDays;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans/' . $this->getId();
    }
}
