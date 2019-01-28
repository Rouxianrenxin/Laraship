<?php

/**
 * Stripe Create SKU Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Create SKU Request
 *
 * @see \Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#create_sku
 */
class CreateSKURequest extends AbstractRequest
{

    /**
     * Set the sku id
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setId($id)
    {
        return $this->setParameter('id', $id);
    }

    /**
     * Get the sku id
     *
     * @return boolean
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set the skup active flag
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setActive($isActive)
    {
        return $this->setParameter('active', $isActive);
    }

    /**
     * Get the sku active flag
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->getParameter('active');
    }

    /**
     * Get the sku price
     *
     * @return array
     */
    public function getPrice()
    {
        return $this->getParameter('price');
    }


    /**
     * Set the skup price value
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setPrice($price)
    {
        return $this->setParameter('price', $price);
    }


    /**
     * Get the sku product
     *
     * @return array
     */
    public function getProduct()
    {
        return $this->getParameter('product');
    }


    /**
     * Set the skup price value
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setProduct($product)
    {
        return $this->setParameter('product', $product);
    }

    /**
     * Get the sku attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->getParameter('attributes');
    }

    /**
     * Set the sku attributes
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setAttributes($skuAttributes)
    {
        return $this->setParameter('attributes', $skuAttributes);
    }


    /**
     * Get the sku attributes
     *
     * @return array
     */
    public function getInventory()
    {
        return $this->getParameter('inventory');
    }

    /**
     * Set the sku Inventory
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setInventory($skuInventory)
    {
        return $this->setParameter('inventory', $skuInventory);
    }


    /**
     * Set the sku currency
     *
     * @return CreateSKURequest provides a fluent interface.
     */
    public function setCurrency($skuCurrency)
    {
        return $this->setParameter('currency', $skuCurrency);
    }

    /**
     * Get the sku currency
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
        $this->validate('id', 'inventory', 'currency', 'product', 'price');

        $data = array(
            'id' => $this->getId(),
            'inventory' => $this->getInventory(),
            'currency' => $this->getCurrency(),
            'product' => $this->getProduct(),
            'price' => $this->getPrice()
        );

        $attributes = $this->getAttributes();

        if ($attributes != null) {
            $data['attributes'] = $attributes;
        }

        $active = $this->getActive();

        if ($active != null) {
            $data['active'] = $active;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/skus';
    }
}
