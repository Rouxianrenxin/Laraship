<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

/**
 * SubscriptionResponse
 */
class SubscriptionResponse extends Response
{

    /**
     * @return string
     */
    public function getSubscriptionReference()
    {
        $SubscriptionRef = null;

        if ($this->isSuccessful()) {
            $subscriptionId = $this->getSubscriptionId();

            if (!empty($subscriptionId)) {
                return $subscriptionId;
            }
        }

        return false;
    }

    public function getSubscriptionId()
    {
        if ($this->isSuccessful()) {
            return $this->data->getSubscriptionId();
        }
        return null;
    }

    public function getSubscriptionPaymentProfileId()
    {
        if ($this->isSuccessful()) {
            return $this->data->getSubscriptionPaymentProfileIdList()[0];
        }
        return null;
    }

}
