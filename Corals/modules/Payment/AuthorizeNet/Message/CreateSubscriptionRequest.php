<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * Authorize Request
 *
 * @method SubscriptionResponse send()
 */
class CreateSubscriptionRequest extends AbstractRequest
{
    public function getData()
    {
        return $this->getSubscriptionData();
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return SubscriptionResponse
     */
    public function sendData($data)
    {


        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($this->getApiLoginId());
        $merchantAuthentication->setTransactionKey($this->getTransactionKey());

        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName($data['name']);
        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength($data['interval_length']);
        $interval->setUnit($data['recurring_unit']);
        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new \DateTime(date('Y-m-d')));
        $paymentSchedule->setTotalOccurrences($data['total_occurances']);
        $paymentSchedule->setTrialOccurrences($data['trial_occurances']);
        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($data['amount']);
        $subscription->setTrialAmount("0.00");

        if ($data['billAddress']) {
            $billto = new AnetAPI\CustomerAddressType();
            $billto->setFirstName($data['name']);
            $billto->setLastName($data['name']);
            $billto->setAddress($data['billing_address']['address_1']);
            $billto->setCity($data['billing_address']['city']);
            $billto->setState($data['billing_address']['state']);
            $billto->setZip($data['billing_address']['zip']);
            $billto->setCountry($data['billing_address']['country']);
            $subscription->setBillTo($billto);

        }

        if ($data['shipAddress']) {
            $shipTo = new AnetAPI\CustomerAddressType();
            $shipTo->setFirstName($data['name']);
            $shipTo->setLastName($data['name']);
            $shipTo->setAddress($data['billing_address']['address_1']);
            $shipTo->setCity($data['billing_address']['city']);
            $shipTo->setState($data['billing_address']['state']);
            $shipTo->setZip($data['billing_address']['zip']);
            $shipTo->setCountry($data['billing_address']['country']);
            $subscription->setShipTo($shipTo);

        }

        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($data['customerProfileId']);
        $profile->setCustomerPaymentProfileId($data['customerPaymentProfileId']);
        $subscription->setProfile($profile);
        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);
        $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());

        /*
        $refId = 'ref' . time();

        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($data['customerProfileId']);
        $paymentProfile = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($data['customerPaymentProfileId']);
        $profileToCharge->setPaymentProfile($paymentProfile);
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($data['amount']);
        $transactionRequestType->setProfile($profileToCharge);
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());
        */
        return new SubscriptionResponse($this, $response);
    }
}
