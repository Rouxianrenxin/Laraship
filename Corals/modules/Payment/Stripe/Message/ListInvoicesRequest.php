<?php

/**
 * Stripe List Invoices Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe List Invoices Request.
 *
 * @see Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#list_invoices
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
