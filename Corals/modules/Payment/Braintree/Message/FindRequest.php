<?php

namespace Corals\Modules\Payment\Braintree\Message;

use Corals\Modules\Payment\Common\Message\ResponseInterface;

/**
 * Authorize Request
 *
 * @method Response send()
 */
class FindRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        return array(
            'transactionReference' => $this->getTransactionReference(),
        );
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $response = $this->braintree->transaction()->find($data['transactionReference']);

        return $this->createResponse($response);
    }
}
