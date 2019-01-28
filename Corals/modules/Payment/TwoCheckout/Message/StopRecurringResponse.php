<?php

namespace Corals\Modules\Payment\TwoCheckout\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;
use Corals\Modules\Payment\Common\Message\ResponseInterface;

/**
 * Response.
 */
class StopRecurringResponse extends AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($this->data['errors']) && $this->data['response_code'] == 'OK';
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return int|null
     */
    public function getCode()
    {
        return isset($this->data['response_code']) ? $this->data['response_code'] : null;
    }

    public function getLineItems()
    {
        return $this->data['sale']['invoices'][0]['lineitems'];
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return isset($this->data['response_message']) ?
            $this->data['response_message'] :
            json_encode($this->data['errors']);
    }

    /**
     * @return string
     */
    public function getCurrentPeriodEndReference()
    {

        return \Carbon\Carbon::now()->timestamp;

    }
}
