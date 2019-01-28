<?php

/**
 * Stripe Pay Order Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Pay Order Request
 *
 * @see Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#pay_order
 */
class PayOrderRequest extends AbstractRequest
{

    /**
     * Set the order id
     *
     * @return PayProductRequest provides a fluent interface.
     */
    public function setId($id)
    {
        return $this->setParameter('id', $id);
    }

    /**
     * Get the order id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set the order customer
     *
     * @return PayProductRequest provides a fluent interface.
     */
    public function setCustomer($customer)
    {
        return $this->setParameter('customer', $customer);
    }

    /**
     * Get the order Customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }


    /**
     * Get the order source
     *
     * @return array
     */
    public function getSource()
    {
        return $this->getParameter('source');
    }


    /**
     * Set the order source value
     *
     * @return PayOrderRequest provides a fluent interface.
     */
    public function setSource($source)
    {
        return $this->setParameter('source', $source);
    }

    /**
     * Get the order status
     *
     * @return array
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }


    /**
     * Set the order email value
     *
     * @return PayOrderRequest provides a fluent interface.
     */
    public function setEmail($email)
    {
        return $this->setParameter('email', $email);
    }


    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $data = [];
        $customer = $this->getCustomer();
        if ($customer != null) {
            $data['customer'] = $customer;
        }
        $source = $this->getSource();
        if ($source != null) {
            $data['source'] = $source;
        }
        $email = $this->getEmail();
        if ($email != null) {
            $data['email'] = $email;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/orders/' . $this->getId() . '/pay';
    }
}
