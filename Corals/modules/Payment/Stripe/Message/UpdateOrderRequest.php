<?php

/**
 * Stripe Update Order Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Update Order Request
 *
 * @see Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#update_order
 */
class UpdateOrderRequest extends AbstractRequest
{
    /**
     * Set the order id
     *
     * @return UpdateProductRequest provides a fluent interface.
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
     * @return UpdateOrderRequest provides a fluent interface.
     */
    public function setCoupon($coupon)
    {
        return $this->setParameter('coupon', $coupon);
    }

    /**
     * Get the order status
     *
     * @return array
     */
    public function getStatus()
    {
        return $this->getParameter('status');
    }


    /**
     * Set the order status value
     *
     * @return UpdateOrderRequest provides a fluent interface.
     */
    public function setStatus($status)
    {
        return $this->setParameter('status', $status);
    }


    /**
     * Set the order  id value
     *
     * @return UpdateOrderRequest provides a fluent interface.
     */
    public function setCustomer($id)
    {
        return $this->setParameter('id', $id);
    }


    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('id');
        $data = [];
        $coupon = $this->getCoupon();
        if ($coupon != null) {
            $data['coupon'] = $coupon;
        }
        $status = $this->getStatus();
        if ($coupon != null) {
            $data['status'] = $status;
        }


        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/orders/' . $this->getId();
    }
}
