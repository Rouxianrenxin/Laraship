<?php

namespace Corals\Modules\Payment\Braintree\Message;

use Corals\Modules\Payment\Common\Message\ResponseInterface;
use Corals\Modules\Subscriptions\Models\Subscription;

/**
 * Authorize Request
 *
 * @method SubscriptionResponse send()
 */
class UpdateSubscriptionRequest extends AbstractRequest
{
    public function getData()
    {
        return array(
            'subscriptionData' => $this->getSubscriptionData(),
            'subscriptionId' => $this->getSubscriptionId(),
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
        $response = $this->braintree->subscription()->update($data['subscriptionid'], $data['subscriptionData']);

        return $this->response = new SubscriptionResponse($this, $response);
    }
}
