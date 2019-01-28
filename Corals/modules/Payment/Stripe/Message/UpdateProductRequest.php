<?php

/**
 * Stripe Update Product Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Update Product Request
 *
 * @see \Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#update_product
 */
class UpdateProductRequest extends AbstractRequest
{

    /**
     * Set the product id
     *
     * @return UpdateProductRequest provides a fluent interface.
     */
    public function setId($id)
    {
        return $this->setParameter('id', $id);
    }

    /**
     * Get the product id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set the product name
     *
     * @return UpdateProductRequest provides a fluent interface.
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
     * Set the product attributes
     *
     * @return UpdateProductRequest provides a fluent interface.
     */
    public function setAttributes($attributes)
    {
        return $this->setParameter('attributes', $attributes);
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
     * @return UpdateProductRequest provides a fluent interface.
     */
    public function setDescription($productDescrption)
    {
        return $this->setParameter('description', $productDescrption);
    }

    /**
     * Set the product active flag
     *
     * @return UpdateProductRequest provides a fluent interface.
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
     * @return UpdateProductRequest provides a fluent interface.
     */
    public function setCaption($productCaption)
    {
        return $this->setParameter('caption', $productCaption);
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
        $this->validate('id', 'name');

        $data = array(
            'name' => $this->getName()
        );


        $caption = $this->getCaption();
        if ($caption != null) {
            $data['caption'] = $caption;
        }

        $attributes = $this->getAttributes();
        if ($attributes != null) {
            $first = true;
            foreach ($attributes as $attribute) {
                if ($first) {
                    $data['attributes[]'] = $attribute;
                    $first = false;
                } else {
                    $data['attributes[]'] = $data['attributes[]'] . '&attributes[]=' . $attribute;
                }

            }
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
        return $this->endpoint . '/products/' . $this->getId();
    }
}
