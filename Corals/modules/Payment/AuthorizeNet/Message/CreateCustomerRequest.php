<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * Authorize Request
 *
 * @method CustomerResponse send()
 */
class CreateCustomerRequest extends AbstractRequest
{
    public function getData()
    {
        return $this->getCustomerData();
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return CustomerResponse
     */
    public function sendData($data)
    {


        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($this->getApiLoginId());
        $merchantAuthentication->setTransactionKey($this->getTransactionKey());

        $refId = 'ref' . time();

        $op = new AnetAPI\OpaqueDataType();
        $op->setDataDescriptor($data['DataDescriptor']);
        $op->setDataValue($data['DataValue']);

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setOpaqueData($op);

        if ($data['billAddress']) {
            // Create the Bill To info for new payment type
            $billto = new AnetAPI\CustomerAddressType();
            $billto->setFirstName($data['name']);
            $billto->setLastName($data['name']);
            $billto->setAddress($data['billAddress']['address_1']);
            $billto->setCity($data['billAddress']['city']);
            $billto->setState($data['billAddress']['state']);
            $billto->setZip($data['billAddress']['zip']);
            $billto->setCountry($data['billAddress']['country']);
        }
        // Create a new Customer Payment Profile object
        $paymentprofile = new AnetAPI\CustomerPaymentProfileType();
        $paymentprofile->setCustomerType('individual');
        $paymentprofile->setBillTo($billto);
        $paymentprofile->setPayment($paymentOne);
        $paymentprofile->setDefaultPaymentProfile(true);
        $paymentprofiles[] = $paymentprofile;
        // Create a new CustomerProfileType and add the payment profile object
        $customerprofile = new AnetAPI\CustomerProfileType();
        $customerprofile->setDescription($data['description']);
        $customerprofile->setMerchantCustomerId($data['MerchantCustomerId']);
        $customerprofile->setEmail($data['email']);
        $customerprofile->setPaymentProfiles($paymentprofiles);
        // Assemble the complete transaction request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setProfile($customerprofile);
        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());

        return new CustomerResponse($this, $response);
    }
}
