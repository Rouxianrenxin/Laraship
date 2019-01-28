<?php

namespace Corals\Modules\Payment\Bank;


use Corals\Modules\Payment\Bank\Exception\BankWebhookFailed;
use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Models\WebhookCall;
use Corals\Modules\Payment\Payment;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Http\Request;

/**
 * Authorize.Net AIM Class
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Bank';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiLoginId' => '',
            'transactionKey' => '',
            'clientKey' => '',
            'testMode' => false,
            'developerMode' => false,
            'hashSecret' => '',
            'signature' => '',
            'liveEndpoint' => 'https://api2.authorize.net',
            'developerEndpoint' => 'https://apitest.authorize.net',
        );
    }

    public function setAuthentication()
    {

        $bank_info = \Settings::get('payment_bank_bank_information');
        $this->setBankInfo($bank_info);


    }

    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "Bank::bank-account-details";
        } else if ($type == "ecommerce") {
            return "Bank::bank-account-details-ecommerce";
        }
    }

    public function getBankInfo()
    {
        return $this->getParameter('BankInfo');
    }

    public function setBankInfo($value)
    {
        return $this->setParameter('BankInfo', $value);
    }


    /**
     * @param array $parameters
     * @return Message\CustomerResponse
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Bank\Message\CreateCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\CustomerResponse
     */
    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Bank\Message\UpdateCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\SubscriptionResponse
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Bank\Message\CreateSubscriptionRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\Response
     */
    public function cancelSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Bank\Message\CancelSubscriptionRequest', $parameters);
    }


    public function prepareCustomerParameters(User $user, $extra = [])
    {
        $parameters['customerData'] = ['description' => $user->full_name, 'email' => $user->email, 'name' => $user->full_name, 'MerchantCustomerId' => $user->id];
        $result = explode('|', $extra['checkoutToken']);
        if (sizeof($result) == 2) {
            list($data_value, $data_descriptor) = $result;
            $parameters['customerData']['DataDescriptor'] = $data_descriptor;
            $parameters['customerData']['DataValue'] = $data_value;
        }
        if ($user->integration_id) {
            list($customer_profile_id, $customer_payment_profile_id) = explode('|', $user->integration_id);
            $parameters['customerData']['customerProfileId'] = $customer_profile_id;
            $parameters['customerData']['customerPaymentProfileId'] = $customer_payment_profile_id;
        }

        $parameters['customerData']['billAddress'] = $extra['billing_address'];

        return $parameters;
    }

    function userRequirePayment(User $user)
    {
        return true;
    }

    /**
     * @param Plan $plan
     * @param User $user
     * @param Subscription|null $subscription
     * @return array
     * @throws Exception
     */
    public function prepareSubscriptionParameters(Plan $plan, User $user, Subscription $subscription = null, $subscription_data = null)
    {


        $parameters['subscriptionData']['subscription_reference'] = session()->get('checkoutToken');
        session()->forget('checkoutToken');

        return $parameters;
    }

    public function prepareSubscriptionCancellationParameters(User $user, Subscription $current_subscription)
    {
        $parameters['SubscriptionCancellationData'] = [
            'subscriptionId' => $current_subscription->subscription_reference,
        ];

        return $parameters;
    }

    public static function webhookHandler(Request $request)
    {
        try {
            $webhookCall = null;


            $eventPayload = $request->getContent();

            if (!static::validate($eventPayload, $request->header('X-Anet-Signature'))) {
                throw BankWebhookFailed::invalidSignature($request->header('X-Anet-Signature'));
            }

            $eventPayload = json_decode($eventPayload, true);

            $data = [
                'event_name' => 'bank.' . $eventPayload['eventType'],
                'payload' => $eventPayload['payload'],
                'gateway' => 'Bank'
            ];
            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
            die();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'bank');
        }
    }


    public static function validate($payload, $AnetSignature)
    {
        $gateway = Payment::create('Bank');
        $gateway->setAuthentication();
        $accepted_algos = array('sha512' => true);
        $parts = explode('=', $AnetSignature);
        $algorithm = $parts[0];
        if (empty($accepted_algos[$algorithm])) {
            return false;
        }
        $inSig = $parts[1];
        $vSig = strtoupper(hash_hmac($algorithm, $payload, $gateway->getSignature()));

        return hash_equals($inSig, $vSig);
    }


}