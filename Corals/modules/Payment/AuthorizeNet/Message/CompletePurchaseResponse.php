<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

/**
 * ChargeResponse
 */
class CompletePurchaseResponse extends Response
{
    /**
     * @return string
     */
    public function getChargeReference()
    {
        $ChargeRef = null;
        if ($this->isSuccessful()) {
            $ChargeRef = $this->data->getTransactionResponse()->getTransId();

        }

        return $ChargeRef;
    }


}
