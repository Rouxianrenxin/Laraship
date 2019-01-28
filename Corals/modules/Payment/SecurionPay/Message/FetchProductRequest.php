<?php

/**
 * SecurionPay Fetch Product Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Fetch Product Request.
 *
 * @link https://securionpay.com/docs/api#retrieve_product
 */
class FetchProductRequest extends AbstractRequest
{
    /**
     * Get the product id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set the product id.
     *
     * @return FetchProductRequest provides a fluent interface.
     */
    public function setId($productId)
    {
        return $this->setParameter('id', $productId);
    }

    public function getData()
    {
        $this->validate('id');
        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/products/' . $this->getId();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
