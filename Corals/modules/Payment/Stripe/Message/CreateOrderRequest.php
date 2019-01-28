<?php

/**
 * Stripe Create Order Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Create Order Request
 *
 * @see Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#create_order
 */
class CreateOrderRequest extends AbstractRequest
{

    /**
     * Get the order coupon
     *
     * @return array
     */
    public function getCoupon()
    {
        return $this->getParameter('coupon');
    }


    /**
     * Set the order coupon value
     *
     * @return CreateOrderRequest provides a fluent interface.
     */
    public function setCoupon($coupon)
    {
        return $this->setParameter('coupon', $coupon);
    }


    /**
     * Get the order customer
     *
     * @return array
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }


    /**
     * Set the order  customer value
     *
     * @return CreateOrderRequest provides a fluent interface.
     */
    public function setCustomer($customer)
    {
        return $this->setParameter('customer', $customer);
    }


    /**
     * Get the order active flag
     *
     * @return boolean
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Set the order  email value
     *
     * @return CreateOrderRequest provides a fluent interface.
     */
    public function setEmail($email)
    {
        return $this->setParameter('email', $email);
    }


    /**
     * Set the order currency
     *
     * @return CreateOrderRequest provides a fluent interface.
     */
    public function setCurrency($orderCurrency)
    {
        return $this->setParameter('currency', $orderCurrency);
    }

    /**
     * Get the order currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * Set the order items
     *
     * @return CreateOrderRequest provides a fluent interface.
     */
    public function setitems($orderItems)
    {
        return $this->setParameter('items', $orderItems);
    }

    /**
     * Get the order  items
     *
     * @return array
     */
    public function getitems()
    {
        return $this->getParameter('items');
    }


    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('currency');

        $data = array(
            'currency' => $this->getCurrency()
        );

        $items = $this->getitems();
        if ($items != null) {
            $data['items'] = $items;
        }

        $customer = $this->getCustomer();
        if ($customer != null) {
            $data['customer'] = $customer;
        }

        $coupon = $this->getCoupon();
        if ($coupon != null) {
            $data['coupon'] = $coupon;
        }

        $email = $this->getEmail();
        if ($email != null) {
            $data['email'] = $email;
        }
        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/orders';
    }
}
