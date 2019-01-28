<?php

/**
 * Stripe Create Product Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Create Product Request
 *
 * @see \Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#create_product
 */
class CreateProductRequest extends AbstractRequest
{

    /**
     * Set the product name
     *
     * @return CreateProductRequest provides a fluent interface.
     */
    public function setName($productName)
    {
        return $this->setParameter('name', $productName);
    }

    /**
     * Get the product name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set the product name
     *
     * @return CreateProductRequest provides a fluent interface.
     */
    public function setShippable($shippable)
    {
        return $this->setParameter('shippable', $shippable);
    }

    /**
     * Get the product name
     *
     * @return string
     */
    public function getShippable()
    {
        return $this->getParameter('shippable');
    }

    /**
     * Set the product attributes
     *
     * @return CreateProductRequest provides a fluent interface.
     */
    public function setAttributes($productAttributes)
    {
        return $this->setParameter('attributes', $productAttributes);
    }

    /**
     * Get the product attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->getParameter('attributes');
    }

    /**
     * Get the product attributes
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getParameter('description');
    }

    /**
     * Set the product description
     *
     * @return CreateProductRequest provides a fluent interface.
     */
    public function setDescription($productDescrption)
    {
        return $this->setParameter('description', $productDescrption);
    }

    /**
     * Set the product active flag
     *
     * @return CreateProductRequest provides a fluent interface.
     */
    public function setActive($isActive)
    {
        return $this->setParameter('active', $isActive);
    }

    /**
     * Get the product active flag
     *
     * @return array
     */
    public function getActive()
    {
        return $this->getParameter('active');
    }

    /**
     * Set the product statement descriptor
     *
     * @return CreateProductRequest provides a fluent interface.
     */
    public function setCaption($caption)
    {
        return $this->setParameter('caption', $caption);
    }

    /**
     * Get the product statement descriptor
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->getParameter('caption');
    }

    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('name');

        $data = array(
            'name' => $this->getName(),
            'shippable' => $this->getShippable(),
        );

        $caption = $this->getCaption();

        if ($caption != null) {
            $data['caption'] = $caption;
        }

        $attributes = $this->getAttributes();

        if ($attributes != null) {
            $data['attributes'] = $attributes;
        }

        $description = $this->getDescription();
        if ($description != null) {
            $data['description'] = $description;
        }

        $active = $this->getActive();

        if ($active != null) {
            $data['active'] = $active;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/products';
    }
}
