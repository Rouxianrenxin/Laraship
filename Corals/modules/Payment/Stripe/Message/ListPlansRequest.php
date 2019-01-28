<?php

/**
 * Stripe List Plans Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

// use Corals\Modules\Payment\Common\Message\AbstractRequest;

/**
 * Stripe List Plans Request.
 *
 * @see Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api/curl#list_plans
 */
class ListPlansRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans';
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
