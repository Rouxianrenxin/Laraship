<?php

/**
 * SecurionPay Update Customer Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Update Customer Request.
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
 * @link https://securionpay.com/docs/api#update_customer
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
        return $this->setParameter('planId', $planId);
    }

    /**
     * Get the plan ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('planId');
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
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('planId');
        $data = array();

        $name = $this->getName();
        if ($name != null) {
            $data['name'] = $name;
        }

        $currency = $this->getCurrency();
        if ($currency != null) {
            $data['currency'] = $currency;
        }

        $amount = $this->getAmount();
        if ($amount != null) {
            $data['amount'] = $amount;
        }

        $metadata = $this->getMetadata();

        if ($metadata != null) {
            $data['metadata'] = $metadata;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans/' . $this->getId();
    }
}
