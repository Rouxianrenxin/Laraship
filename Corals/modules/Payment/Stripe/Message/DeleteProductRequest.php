<?php

/**
 * Stripe Delete Product Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Delete Product Request.
 *
 * @link https://stripe.com/docs/api#delete_product
 */
class DeleteProductRequest extends AbstractRequest
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
     * @return DeleteProductRequest provides a fluent interface.
     */
    public function setId($productId)
    {
        return $this->setParameter('id', $productId);
    }

    public function getData()
    {
        $this->validate('id');

        return;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/products/' . $this->getId();
    }

    public function getHttpMethod()
    {
        return 'DELETE';
    }
}
