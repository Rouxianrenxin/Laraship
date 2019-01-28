<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

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


        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($this->getApiLoginId());
        $merchantAuthentication->setTransactionKey($this->getTransactionKey());

        $refId = 'ref' . time();
        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);

        $request->setSubscriptionId($data['subscriptionId']);


        $controller = new AnetController\ARBCreateSubscriptionController($request);
        $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());

        return new SubscriptionResponse($this, $response);
    }
}
