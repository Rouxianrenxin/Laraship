<?php

namespace Corals\Modules\Payment\TwoCheckout\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;
use Corals\Modules\Payment\Common\Message\ResponseInterface;
use Corals\Modules\Payment\Payment;

/**
 * Response.
 */
class TokenPurchaseResponse extends AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $responseCode = $this->data['response']['responseCode'];

        return isset($responseCode) ? $responseCode == 'APPROVED' : false;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return int|null
     */
    public function getCode()
    {
        return isset($this->data['exception']) ? $this->data['exception']['errorCode'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return isset($this->data['exception']) ? $this->data['exception']['errorMsg'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        return isset($this->data['response']['orderNumber']) ? $this->data['response']['orderNumber'] : null;
    }

    /**
     * Get the invoice-item subscription reference
     *
     * @return string
     */
    public function getSubscriptionReference()
    {
        $sale_id = $this->getTransactionReference();
        $gateway = Payment::create('TwoCheckout');
        $gateway->setAuthentication();
        $parameters = [
            'admin_username' => $gateway->getAdminUsername(),
            'admin_password' => $gateway->getAdminPassword(),
            'sale_id' => $sale_id
        ];
        $request = $gateway->fetchSaleDetails($parameters);
        $response = $request->send();
        $lines_items = $response->getLineItems();
        return $sale_id . "|" . $lines_items[0]['lineitem_id'];

    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionId()
    {
        return isset($this->data['response']['merchantOrderId']) ? $this->data['response']['merchantOrderId'] : null;
    }
}
