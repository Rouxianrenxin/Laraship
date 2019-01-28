<?php

namespace Corals\Modules\Payment\Bank\Message;

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

        return $this->data['subscription_reference'];


    }




}
