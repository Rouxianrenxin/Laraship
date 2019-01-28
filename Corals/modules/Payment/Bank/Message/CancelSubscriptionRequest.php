<?php

namespace Corals\Modules\Payment\Bank\Message;

use Carbon\Carbon;


/**
 * Authorize Request
 *
 * @method SubscriptionResponse send()
 */
class CancelSubscriptionRequest extends AbstractRequest
{
    public function getData()
    {
        return $this->getSubscriptionCancellationData();
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return SubscriptionResponse
     */
    public function sendData($data)
    {

        $response['status'] = true;

        return new SubscriptionResponse($this, $response);
    }
}
