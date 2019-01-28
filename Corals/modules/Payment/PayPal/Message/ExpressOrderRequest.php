<?php

namespace Corals\Modules\Payment\PayPal\Message;

/**
 * PayPal Express Order Request
 */
class ExpressOrderRequest extends ExpressAuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Order';

        return $data;
    }
}
