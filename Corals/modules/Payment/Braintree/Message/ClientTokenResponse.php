<?php

namespace Corals\Modules\Payment\Braintree\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;
use Corals\Modules\Payment\Common\Message\RequestInterface;

/**
 * ClientTokenResponse
 */
class ClientTokenResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return true;
    }

    public function getToken()
    {
        return $this->data;
    }
}
