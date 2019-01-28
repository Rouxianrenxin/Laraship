<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

/**
 * CustomerResponse
 */
class GetCustomerResponse extends CustomerResponse
{

    /**
     * @return string
     */
    public function getCustomerReference()
    {
        $CustomerRef = null;

        if ($this->isSuccessful()) {
            $data['customerProfileId'] = $this->getCustomerProfileId();
            $data['customerPaymentProfileId'] = $this->getCustomerPaymentProfileId();

            if (!empty($data['customerProfileId']) && !empty($data['customerPaymentProfileId'])) {
                // For card reference both profileId and payment profileId should exist
                $CustomerRef = implode('|', $data);
            }
        }

        return $CustomerRef;
    }

    public function getCustomerProfileId()
    {
        if ($this->isSuccessful()) {
            return $this->data->getPaymentProfile()->getCustomerProfileId();
        }
        return null;
    }

    public function getCustomerPaymentProfileId()
    {
        if ($this->isSuccessful()) {
            return $this->data->getPaymentProfile()->getCustomerPaymentProfileId();
        }
        return null;
    }

}
