<?php

/**
 * Stripe Delete SKU Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Delete SKU Request.
 *
 * @link https://stripe.com/docs/api#delete_sku
 */
class DeleteSKURequest extends AbstractRequest
{
    /**
     * Get the sku id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set the sku id.
     *
     * @return DeleteSKURequest provides a fluent interface.
     */
    public function setId($skuId)
    {
        return $this->setParameter('id', $skuId);
    }

    public function getData()
    {
        $this->validate('id');

        return;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/skus/' . $this->getId();
    }

    public function getHttpMethod()
    {
        return 'DELETE';
    }
}
