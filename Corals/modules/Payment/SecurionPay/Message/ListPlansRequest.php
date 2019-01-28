<?php

/**
 * SecurionPay List Plans Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

// use Corals\Modules\Payment\Common\Message\AbstractRequest;

/**
 * SecurionPay List Plans Request.
 *
 * @see Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api/curl#list_plans
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
