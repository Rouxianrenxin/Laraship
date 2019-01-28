<?php

namespace Corals\Modules\Payment\Omise\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;

/**
 * Omise Complete Purchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        if ($this->data['status']) {
            return true;
        } else {
            return false;

        }
    }

    /**
     * @see \Corals\Modules\Payment\Omise\Message\Response::getTransactionReference()
     * @return array|null
     */
    public function getChargeReference()
    {
        if (isset($this->data['object']) && $this->data['object'] == 'charge') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Transaction reference returned by omise or null on payment failure.
     *
     * @return mixed|null
     */
    public function getTransactionReference()
    {
        return isset($this->data['order_number']) ? $this->data['order_number'] : null;
    }

    public function getTransactionInvoice()
    {
        return isset($this->data['invoice_id']) ? $this->data['invoice_id'] : null;
    }

    /**
     * Transaction ID.
     *
     * @return mixed|null
     */
    public function getTransactionId()
    {
        return isset($this->data['merchant_order_id']) ? $this->data['merchant_order_id'] : null;
    }
}
