<?php

/**
 * SecurionPay Create Subscription Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

/**
 * SecurionPay Create Subscription Request
 *
 * @see \Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api/php#create_subscription
 */
class CreateInvoiceRequest extends AbstractRequest
{


    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function amount($amount)
    {
        return $this->setParameter('amount', $amount);
    }


    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    public function currency($currency)
    {
        return $this->setParameter('currency', $currency);
    }

    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function description($description)
    {
        return $this->setParameter('description', $description);
    }


    public function getCaptured()
    {
        return $this->getParameter('captured');
    }

    public function setCaptured($captured)
    {
        return $this->setParameter('captured', $captured);
    }

    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    public function metadata($metadata)
    {
        return $this->setParameter('metadata', $metadata);
    }

    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('customerReference', 'amount', 'currency');

        $data = array(
            'customerId' => $this->getCustomerReference(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency()
        );

        if ($this->getDescription()) {
            $data['description'] = $this->getDescription();
        }

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        if ($this->getCaptured()) {
            $data['captured'] = $this->getCaptured();
        }


        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/charges';
    }
}
