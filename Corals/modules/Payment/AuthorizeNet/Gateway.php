<?php

namespace Corals\Modules\Payment\AuthorizeNet;


use Corals\Modules\Payment\AuthorizeNet\Exception\AuthorizeNetWebhookFailed;
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
        return 'AuthorizeNet';
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

        $sandbox = \Settings::get('payment_authorizenet_sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $sandbox_mode = true;
            $login_id = \Settings::get('payment_authorizenet_sandbox_login_id');
            $transaction_key = \Settings::get('payment_authorizenet_sandbox_transaction_key');
            $client_key = \Settings::get('payment_authorizenet_sandbox_client_key');
            $signature = \Settings::get('payment_authorizenet_sandbox_signature');


        } else {
            $sandbox_mode = false;
            $login_id = \Settings::get('payment_authorizenet_live_login_id');
            $transaction_key = \Settings::get('payment_authorizenet_live_transaction_key');
            $client_key = \Settings::get('payment_authorizenet_live_client_key');
            $signature = \Settings::get('payment_authorizenet_live_signature');


        }
        $this->setClientKey($client_key);
        $this->setTransactionKey($transaction_key);
        $this->setDeveloperMode($sandbox_mode);
        $this->setApiLoginId($login_id);
        $this->setSignature($signature);


    }

    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "AuthorizeNet::subscription-checkout";

        } else {
            return "AuthorizeNet::ecommerce-checkout";

        }
    }

    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    public function getApiLoginId()
    {
        return $this->getParameter('apiLoginId');
    }

    public function setApiLoginId($value)
    {
        return $this->setParameter('apiLoginId', $value);
    }

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function setHashSecret($value)
    {
        return $this->setParameter('hashSecret', $value);
    }

    public function getHashSecret()
    {
        return $this->getParameter('hashSecret');
    }

    public function setEndpoints($endpoints)
    {
        $this->setParameter('liveEndpoint', $endpoints['live']);
        return $this->setParameter('developerEndpoint', $endpoints['developer']);
    }

    public function getLiveEndpoint()
    {
        return $this->getParameter('liveEndpoint');
    }

    public function setLiveEndpoint($value)
    {
        return $this->setParameter('liveEndpoint', $value);
    }

    public function getDeveloperEndpoint()
    {
        return $this->getParameter('developerEndpoint');
    }

    public function setDeveloperEndpoint($value)
    {
        return $this->setParameter('developerEndpoint', $value);
    }

    public function getDuplicateWindow()
    {
        return $this->getParameter('duplicateWindow');
    }

    public function setDuplicateWindow($value)
    {
        return $this->setParameter('duplicateWindow', $value);
    }


    /**
     * @param array $parameters
     * @return Message\CustomerResponse
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\AuthorizeNet\Message\CreateCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\CustomerResponse
     */
    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\AuthorizeNet\Message\UpdateCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\SubscriptionResponse
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\AuthorizeNet\Message\CreateSubscriptionRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\Response
     */
    public function cancelSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\AuthorizeNet\Message\CancelSubscriptionRequest', $parameters);
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

    public function prepareCreateChargeParameters($order, User $user, $checkoutDetails)
    {
        $parameters['chargeData'] = [
            'amount' => \Payments::currency_convert($order->amount, $order->currency, \Payments::admin_currency_code()),
            'description' => 'Store Order #' . $order->order_number,
            'order_number' => 'Order #' . $order->order_number
        ];

        $checkoutTokenData = explode('|', $checkoutDetails['token']);


        if (sizeof($checkoutTokenData) == 2) {
            list($data_value, $data_descriptor) = $checkoutTokenData;
            $parameters['chargeData']['DataDescriptor'] = $data_descriptor;
            $parameters['chargeData']['DataValue'] = $data_value;
        }

        return $parameters;
    }


    public function prepareCreateMultiOrderChargeParameters($orders, User $user, $checkoutDetails)
    {
        $amount = 0;
        $description = "Order # ";
        $currency = "";
        foreach ($orders as $order) {
            $amount += $order->amount;
            $currency = $order->currency;
            $description .= $order->order_number . ",";
        }

        $parameters['chargeData'] = [
            'amount' => \Payments::currency_convert($amount, $currency, \Payments::admin_currency_code()),
            'description' => $description,
            'order_number' => 'Order #' . $order->order_number
        ];

        $checkoutTokenData = explode('|', $checkoutDetails['token']);


        if (sizeof($checkoutTokenData) == 2) {
            list($data_value, $data_descriptor) = $checkoutTokenData;
            $parameters['chargeData']['DataDescriptor'] = $data_descriptor;
            $parameters['chargeData']['DataValue'] = $data_value;
        }

        return $parameters;

    }


    function userRequirePayment(User $user)
    {
        if (is_null($user->integration_id)) {
            return true;

        }
        return false;
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


        $parameters['subscriptionData']['name'] = $plan->name;
        $parameters['subscriptionData']['amount'] = $plan->price;
        $parameters['subscriptionData']['total_occurances'] = 1000;
        switch ($plan->bill_cycle) {
            case 'day':
                $recurring_unit = 'days';
                $interval_length = $plan->bill_frequency;
                break;

            case 'month':
                $recurring_unit = 'months';
                $interval_length = $plan->bill_frequency;
                break;

            case 'year':
                $recurring_unit = 'months';
                $interval_length = $plan->bill_frequency * 12;
                break;

            default:
                $recurring_unit = $plan->bill_cycle . 's';
                $interval_length = $plan->bill_frequency;

        }
        $parameters['subscriptionData']['trial_occurances'] = $plan->trial_period;
        $parameters['subscriptionData']['recurring_unit'] = $recurring_unit;
        $parameters['subscriptionData']['interval_length'] = $interval_length;
        list($customer_profile_id, $customer_payment_profile_id) = explode('|', $user->integration_id);
        $parameters['subscriptionData']['customerProfileId'] = $customer_profile_id;
        $parameters['subscriptionData']['customerPaymentProfileId'] = $customer_payment_profile_id;
        $parameters['subscriptionData']['billAddress'] = $subscription_data['billing_address'];
        $parameters['subscriptionData']['shipAddress'] = $subscription_data['shipping_address'];

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
                throw AuthorizeNetWebhookFailed::invalidSignature($request->header('X-Anet-Signature'));
            }

            $eventPayload = json_decode($eventPayload, true);

            $data = [
                'event_name' => 'authorizenet.' . $eventPayload['eventType'],
                'payload' => $eventPayload['payload'],
                'gateway' => 'AuthorizeNet'
            ];
            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
            die();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'authorizenet');
        }
    }


    public static function validate($payload, $AnetSignature)
    {
        $gateway = Payment::create('AuthorizeNet');
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

    /**
     * create Charge
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Omise\Message\
     */
    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\AuthorizeNet\Message\CompletePurchaseRequest', $parameters);
    }

}