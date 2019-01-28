<?php

/**
 * Stripe Update SKU Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Update SKU Request
 *
 * @see \Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#update_sku
 */
class UpdateSKURequest extends AbstractRequest
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
     * Set the skup active flag
     *
     * @return UpdateSKURequest provides a fluent interface.
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
     * @return UpdateSKURequest provides a fluent interface.
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
     * @return UpdateSKURequest provides a fluent interface.
     */
    public function setInventory($skuInventory)
    {
        return $this->setParameter('inventory', $skuInventory);
    }


    /**
     * Set the sku currency
     *
     * @return UpdateSKURequest provides a fluent interface.
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
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('id');

        $data = [];

        if ($this->getPrice()) {
            $data['price'] = $this->getPrice();
        }

        $inventory = $this->getInventory();

        if ($inventory != null) {
            $data['inventory'] = $inventory;
        }

        $currency = $this->getCurrency();

        if ($currency != null) {
            $data['currency'] = $currency;
        }

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
        return $this->endpoint . '/skus/' . $this->getId();
    }
}
