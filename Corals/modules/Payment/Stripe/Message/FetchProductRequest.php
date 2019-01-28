<?php

/**
 * Stripe Fetch Product Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Fetch Product Request.
 *
 * @link https://stripe.com/docs/api#retrieve_product
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
