<?php
/**
 * PayPal REST List Plans Request
 */

namespace Corals\Modules\Payment\PayPal\Message;

/*
 * @link https://developer.paypal.com/docs/api/payments.billing-plans#billing-plans_get
 */

class RestFetchPlanRequest extends AbstractRestRequest
{
    /**
     *
     * Get the request page
     *
     * @return integer
     */

    public function getId()
    {
        return $this->getParameter('id');
    }


    /**
     * Set the request page
     *
     * @param integer $value
     * @return AbstractRestRequest provides a fluent interface.
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }


    public function getData()
    {
        return array();
    }

    /**
     * Get HTTP Method.
     *
     * The HTTP method for list plans requests must be GET.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/billing-plans/' . $this->getId();
    }
}
