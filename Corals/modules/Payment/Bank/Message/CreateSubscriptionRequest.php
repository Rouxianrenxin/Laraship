<?php

namespace Corals\Modules\Payment\Bank\Message;

use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * Authorize Request
 *
 * @method SubscriptionResponse send()
 */
class CreateSubscriptionRequest extends AbstractRequest
{
    public function getData()
    {
        return $this->getSubscriptionData();
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return SubscriptionResponse
     */
    public function sendData($data)
    {


        $response['subscription_reference'] = $data['subscription_reference'];

        return new SubscriptionResponse($this, $response);
    }
}
