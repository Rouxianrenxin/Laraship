<?php

namespace Corals\Modules\Payment\Braintree\Message;

use Corals\Modules\Payment\Common\Message\ResponseInterface;

/**
 * Authorize Request
 *
 * @method CustomerResponse send()
 */
class UpdateCustomerRequest extends AbstractRequest
{
    public function getData()
    {
        return array(
            'customerData' => $this->getCustomerData(),
            'customerId' => $this->getCustomerId(),
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
        $response = $this->braintree->customer()->update($data['customerId'], $data['customerData']);
        return $this->response = new CustomerResponse($this, $response);
    }
}
