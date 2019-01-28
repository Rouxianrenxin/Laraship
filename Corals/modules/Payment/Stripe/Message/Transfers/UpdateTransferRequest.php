<?php

/**
 * Stripe Update Transfer Request (Connect only).
 */

namespace Corals\Modules\Payment\Stripe\Message\Transfers;

use Corals\Modules\Payment\Stripe\Message\AbstractRequest;

/**
 * Stripe Update Transfer Request.
 *
 * Updates the specified transfer by setting the values of the parameters passed.
 * Any parameters not provided will be left unchanged.
 *
 * <code>
 *   // Once the transaction has been authorized, we can capture it for final payment.
 *   $transaction = $gateway->updateTransfer(array(
 *       'transferReference' => '{TRANSFER_ID}',
 *       'metadata'          => [],
 *   ));
 *   $response = $transaction->send();
 * </code>
 *
 * @link https://stripe.com/docs/api#update_transfer
 */
class UpdateTransferRequest extends AbstractRequest
{
    /**
     * Get the plan ID
     *
     * @return string
     */
    public function getTransferReference()
    {
        return $this->getParameter('transferReference');
    }

    /**
     * Set the plan ID
     *
     * @param string $value
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function setTransferReference($value)
    {
        return $this->setParameter('transferReference', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('transferReference');

        $data = array();

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint . '/transfers/' . $this->getTransferReference();
    }
}
