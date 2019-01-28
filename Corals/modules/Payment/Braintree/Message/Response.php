<?php

namespace Corals\Modules\Payment\Braintree\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;

/**
 * Response
 */
class Response extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if (isset($this->data->success)) {
            return $this->data->success;
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data->message) && $this->data->message) {
            return $this->data->message;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->transactionValue('status');
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->transactionValue('id');
    }

    /**
     * @return string
     */
    public function getSubscriptionReference()
    {
        return $this->data->subscription->id;
    }

    /**
     * @return string
     */
    public function getPaymentMethodReference()
    {
        return $this->data->customer->paymentMethods[0]->token;
    }

    /**
     * @return string
     */
    public function getChargeReference()
    {
        return $this->data->transaction->id;
    }

    /**
     * @return string
     */
    public function getCurrentPeriodEndReference()
    {
        if ($this->data->subscription->billingPeriodEndDate) {
            return $this->data->subscription->billingPeriodEndDate->getTimestamp();
        } else {
            return \Carbon\Carbon::now()->timestamp;
        }
    }


    /**
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->data->customer->id;
    }


    /**
     * @return string|null
     */
    public function getAmount()
    {
        return $this->transactionValue('amount');
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->transactionValue('orderId');
    }

    /**
     * Return a value from the transaction object
     *
     * @param  string $key
     * @return mixed
     */
    protected function transactionValue($key)
    {
        if (isset($this->data->transaction) && $this->data->transaction && isset($this->data->transaction->$key)) {
            return $this->data->transaction->$key;
        }

        return null;
    }
}
