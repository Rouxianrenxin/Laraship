<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * Authorize Request
 *
 * @method CustomerResponse send()
 */
class UpdateCustomerRequest extends AbstractRequest
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

        //Set profile ids of profile to be updated
        if (isset($data['DataDescriptor']) && isset($data['DataValue'])) {
            $request = new AnetAPI\UpdateCustomerPaymentProfileRequest();
            $request->setCustomerProfileId($data['customerProfileId']);


        } else {
            $request = new AnetAPI\GetCustomerProfileRequest();
            $request->setCustomerProfileId($data['customerProfileId']);

        }
        $request->setMerchantAuthentication($merchantAuthentication);

        $refId = 'ref' . time();
        $request->setRefId($refId);

        // Create the Bill To info for new payment type
        $billto = new AnetAPI\CustomerAddressType();
        $billto->setFirstName($data['name']);
        $billto->setLastName($data['name']);
        $billto->setAddress($data['billAddress']['address_1']);
        $billto->setCity($data['billAddress']['city']);
        $billto->setState($data['billAddress']['state']);
        $billto->setZip($data['billAddress']['zip']);
        $billto->setCountry($data['billAddress']['country']);

        // Create the Customer Payment Profile object
        $paymentprofile = new AnetAPI\CustomerPaymentProfileExType();


        $paymentprofiles = [];
        if (isset($data['DataDescriptor']) && isset($data['DataValue'])) {
            $op = new AnetAPI\OpaqueDataType();
            $op->setDataDescriptor($data['DataDescriptor']);
            $op->setDataValue($data['DataValue']);

            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setOpaqueData($op);
            $paymentprofile->setPayment($paymentOne);
            $paymentprofile->setDefaultPaymentProfile(true);

            $paymentprofiles[] = $paymentprofile;
            // Create a new CustomerProfileType and add the payment profile object
            $customerprofile = new AnetAPI\CustomerProfileType();
            $customerprofile->setPaymentProfiles($paymentprofiles);
            $paymentprofile->setBillTo($billto);
            $paymentprofile->setCustomerPaymentProfileId($data['customerPaymentProfileId']);

            $request->setPaymentProfile($paymentprofile);


        }


        // Submit a UpdatePaymentProfileRequest
        if (sizeof($paymentprofiles) > 0) {
            $controller = new AnetController\UpdateCustomerPaymentProfileController($request);
            $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());
            //return new CustomerResponse($this, $response);
        }

        $getRequest = new AnetAPI\GetCustomerPaymentProfileRequest();
        $getRequest->setMerchantAuthentication($merchantAuthentication);
        $getRequest->setRefId($refId);
        $getRequest->setCustomerProfileId($data['customerProfileId']);
        $getRequest->setCustomerPaymentProfileId($data['customerPaymentProfileId']);
        $controller = new AnetController\GetCustomerPaymentProfileController($getRequest);
        $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());
        return new GetCustomerResponse($this, $response);


    }
}
