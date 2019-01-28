<?php

/**
 * SecurionPay List Invoices Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay List Invoices Request.
 *
 * @see Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api#list_invoices
 */
class ListInvoicesRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/invoices';
    }

    public function getHttpMethod()
    {
        return 'GET';
    }
}
