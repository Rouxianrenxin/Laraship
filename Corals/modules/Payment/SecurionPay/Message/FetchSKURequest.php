<?php

/**
 * SecurionPay Fetch SKU Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Fetch SKU Request.
 *
 * @link https://securionpay.com/docs/api#retrieve_sku
 */
class FetchSKURequest extends AbstractRequest
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
     * @return FetchSKURequest provides a fluent interface.
     */
    public function setId($skuId)
    {
        return $this->setParameter('id', $skuId);
    }

    public function getData()
    {
        $this->validate('id');
        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/skus/' . $this->getId();
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
