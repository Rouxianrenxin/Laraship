<?php
/**
 * Paypal Item
 */

namespace Corals\Modules\Payment\PayPal;

use Corals\Modules\Payment\Common\Item;

/**
 * Class PayPalItem
 *
 * @package Corals\Modules\Payment\PayPal
 */
class PayPalItem extends Item
{
    /**
     * {@inheritDoc}
     */
    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * Set the item code
     */
    public function setCode($value)
    {
        return $this->setParameter('code', $value);
    }
}
