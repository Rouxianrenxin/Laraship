<?php

/**
 * SecurionPay Response.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;
use Corals\Modules\Payment\Common\Message\RequestInterface;

/**
 * SecurionPay Response.
 *
 * This is the response class for all SecurionPay requests.
 *
 * @see \Corals\Modules\Payment\SecurionPay\Gateway
 */
class Response extends AbstractResponse
{
    /**
     * Request id
     *
     * @var string URL
     */
    protected $requestId = null;

    /**
     * @var array
     */
    protected $headers = [];

    public function __construct(RequestInterface $request, $data, $headers = [])
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
    }

    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($this->data['error']);
    }

    /**
     * Get the charge reference from the response of FetchChargeRequest.
     *
     * @deprecated 2.3.3:3.0.0 duplicate of \Corals\Modules\Payment\SecurionPay\Message\Response::getTransactionReference()
     * @see \Corals\Modules\Payment\SecurionPay\Message\Response::getTransactionReference()
     * @return array|null
     */
    public function getChargeReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'charge') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the transaction reference.
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['objectType']) && 'charge' === $this->data['objectType']) {
            return $this->data['id'];
        }
        if (isset($this->data['error']) && isset($this->data['error']['charge'])) {
            return $this->data['error']['charge'];
        }

        return null;
    }

    /**
     * Get the balance transaction reference.
     *
     * @return string|null
     */
    public function getBalanceTransactionReference()
    {
        if (isset($this->data['objectType']) && 'charge' === $this->data['objectType']) {
            return $this->data['balance_transaction'];
        }
        if (isset($this->data['objectType']) && 'balance_transaction' === $this->data['objectType']) {
            return $this->data['id'];
        }
        if (isset($this->data['error']) && isset($this->data['error']['charge'])) {
            return $this->data['error']['charge'];
        }

        return null;
    }

    /**
     * Get a customer reference, for createCustomer requests.
     *
     * @return string|null
     */
    public function getCustomerReference()
    {
        if (isset($this->data['objectType']) && 'customer' === $this->data['objectType']) {
            return $this->data['id'];
        }
        if (isset($this->data['objectType']) && 'card' === $this->data['objectType']) {
            if (!empty($this->data['customer'])) {
                return $this->data['customer'];
            }
        }

        return null;
    }

    /**
     * Get a CurrentPeriodEnd reference, for Subscription requests.
     *
     * @return string|null
     */
    public function getCurrentPeriodEndReference()
    {
        if (isset($this->data['objectType']) && 'subscription' === $this->data['objectType']) {
            return $this->data['currentPeriodEnd'];
        }

        return null;
    }

    /**
     * Get a card reference, for createCard or createCustomer requests.
     *
     * @return string|null
     */
    public function getCardReference()
    {
        if (isset($this->data['objectType']) && 'customer' === $this->data['objectType']) {
            if (isset($this->data['default_source']) && !empty($this->data['default_source'])) {
                return $this->data['default_source'];
            }

            if (isset($this->data['default_card']) && !empty($this->data['default_card'])) {
                return $this->data['default_card'];
            }

            if (!empty($this->data['id'])) {
                return $this->data['id'];
            }
        }
        if (isset($this->data['objectType']) && 'card' === $this->data['objectType']) {
            if (!empty($this->data['id'])) {
                return $this->data['id'];
            }
        }
        if (isset($this->data['objectType']) && 'charge' === $this->data['objectType']) {
            if (!empty($this->data['source'])) {
                if (!empty($this->data['source']['id'])) {
                    return $this->data['source']['id'];
                }
            }
        }

        return null;
    }

    /**
     * Get a token, for createCard requests.
     *
     * @return string|null
     */
    public function getToken()
    {
        if (isset($this->data['objectType']) && 'token' === $this->data['objectType']) {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the card data from the response.
     *
     * @return array|null
     */
    public function getCard()
    {
        if (isset($this->data['card'])) {
            return $this->data['card'];
        }

        return null;
    }

    /**
     * Get the card data from the response of purchaseRequest.
     *
     * @return array|null
     */
    public function getSource()
    {
        if (isset($this->data['source']) && $this->data['source']['objectType'] == 'card') {
            return $this->data['source'];
        }

        return null;
    }

    /**
     * Get the subscription reference from the response of CreateSubscriptionRequest.
     *
     * @return array|null
     */
    public function getSubscriptionReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'subscription') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the event reference from the response of FetchEventRequest.
     *
     * @return array|null
     */
    public function getEventReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'event') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the invoice reference from the response of FetchInvoiceRequest.
     *
     * @return array|null
     */
    public function getInvoiceReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'charge') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the transfer reference from the response of CreateTransferRequest,
     * UpdateTransferRequest, and FetchTransferRequest.
     *
     * @return array|null
     */
    public function getTransferReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'transfer') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the transfer reference from the response of CreateTransferReversalRequest,
     * UpdateTransferReversalRequest, and FetchTransferReversalRequest.
     *
     * @return array|null
     */
    public function getTransferReversalReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'transfer_reversal') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the list object from a result
     *
     * @return array|null
     */
    public function getList()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'list') {
            return $this->data['data'];
        }

        return null;
    }

    /**
     * Get the subscription plan from the response of CreateSubscriptionRequest.
     *
     * @return array|null
     */
    public function getPlan()
    {
        if (isset($this->data['plan'])) {
            return $this->data['plan'];
        } elseif (array_key_exists('objectType', $this->data) && $this->data['objectType'] == 'plan') {
            return $this->data;
        }

        return null;
    }

    /**
     * Get plan id
     *
     * @return string|null
     */
    public function getPlanId()
    {
        $plan = $this->getPlan();
        if ($plan && array_key_exists('id', $plan)) {
            return $plan['id'];
        }

        return null;
    }

    /**
     * Get invoice-item reference
     *
     * @return string|null
     */
    public function getInvoiceItemReference()
    {
        if (isset($this->data['objectType']) && $this->data['objectType'] == 'invoiceitem') {
            return $this->data['id'];
        }

        return null;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['error']) && isset($this->data['error']['message'])) {
            return $this->data['error']['message'];
        }

        return null;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getCode()
    {
        if (!$this->isSuccessful() && isset($this->data['error']) && isset($this->data['error']['code'])) {
            return $this->data['error']['code'];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }
}