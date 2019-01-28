<?php

namespace Corals\Modules\Payment\Omise\Message;

use Corals\Modules\Payment\Common\Exception\InvalidResponseException;

/**
 * Omise Complete Purchase Request.
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    /**
     * {@inheritdoc}
     *
     * @return mixed
     *
     * @throws InvalidResponseException
     */
    public function getData()
    {

        $this->validate('amount', 'currency', 'token', 'description');

        $data = array();
        $data['amount'] = intval($this->getAmount());
        $data['card'] = $this->getToken();
        $data['currency'] = $this->getCurrency();
        $data['description'] = $this->getDescription();

        return $data;
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        /* Defined OMISE KEYS */
        define('OMISE_PUBLIC_KEY', $this->getPublicKey());
        define('OMISE_SECRET_KEY', $this->getPrivateKey());

        $response = \OmiseCharge::create($data);

        return new CompletePurchaseResponse($this, $response);
    }
}
