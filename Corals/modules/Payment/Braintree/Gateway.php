<?php

namespace Corals\Modules\Payment\Braintree;

use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Payment\Braintree\Exception\BraintreeWebhookFailed;
use Corals\Modules\Payment\Common\AbstractGateway;
use Braintree_Gateway;
use Braintree_Configuration;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Payment\Models\WebhookCall;
use Corals\User\Models\User;
use Corals\Modules\Payment\Common\Http\ClientInterface;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Corals\Modules\Subscriptions\Classes\Subscription as SubscriptionClass;

/**
 * Braintree Gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * @var \Braintree_Gateway
     */
    protected $braintree;

    /**
     * Create a new gateway instance
     *
     * @param ClientInterface $httpClient A Guzzle client to make API calls with
     * @param HttpRequest $httpRequest A Symfony HTTP request object
     * @param Braintree_Gateway $braintree The Braintree gateway
     */
    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null, Braintree_Gateway $braintree = null)
    {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib/autoload.php');

        $this->braintree = $braintree ?: Braintree_Configuration::gateway();
        parent::__construct($httpClient, $httpRequest);

    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest($class, array $parameters)
    {
        $obj = new $class($this->httpClient, $this->httpRequest, $this->braintree);

        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }

    public function getName()
    {
        return 'Braintree';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'publicKey' => '',
            'privateKey' => '',
            'testMode' => false,
        );
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    public function setPublicKey($value)
    {
        return $this->setParameter('publicKey', $value);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @param array $parameters
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\AuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\CaptureRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\ClientTokenRequest
     */
    public function clientToken(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\ClientTokenRequest', $parameters);
    }

    /**
     * @param string $id
     * @return Message\FindCustomerRequest
     */
    public function findCustomer($id)
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\FindCustomerRequest', array('customerId' => $id));
    }

    /**
     * @param array $parameters
     * @return Message\CreateCustomerRequest
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\CreateCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\DeleteCustomerRequest
     */
    public function deleteCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\DeleteCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\UpdateCustomerRequest
     */
    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\UpdateCustomerRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function find(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\FindRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\CreateMerchantAccountRequest
     */
    public function createMerchantAccount(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\CreateMerchantAccountRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\UpdateMerchantAccountRequest
     */
    public function updateMerchantAccount(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\UpdateMerchantAccountRequest', $parameters);
    }

    public function preparePaymentMethodParameters(User $user, $extras = [])
    {
        return array_merge([
            'customerId' => $user->integration_id,
            'token' => $extras['paymentMethodNonce'],
        ], $extras);
    }

    /**
     * @param array $parameters
     * @return Message\CreatePaymentMethodRequest
     */
    public function createPaymentMethod(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\CreatePaymentMethodRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\DeletePaymentMethodRequest
     */
    public function deletePaymentMethod(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\DeletePaymentMethodRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\UpdatePaymentMethodRequest
     */
    public function updatePaymentMethod(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\UpdatePaymentMethodRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function releaseFromEscrow(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\ReleaseFromEscrowRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\VoidRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\CreateSubscriptionRequest', $parameters);
    }

    /**
     * @param string $subscriptionId
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function cancelSubscription($subscriptionId)
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\CancelSubscriptionRequest', array('id' => $subscriptionId));
    }

    /**
     * @return \Corals\Modules\Payment\Common\Message\PlansRequest
     */
    public function plans()
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\PlanRequest', array());
    }

    /**
     * Fetch Plan
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchPlanRequest
     */
    public function fetchPlan(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\PlanRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Braintree_WebhookNotification
     *
     * @throws \Braintree_Exception_InvalidSignature
     */
    public function parseNotification(array $parameters = array())
    {
        return \Braintree_WebhookNotification::parse(
            $parameters['bt_signature'],
            $parameters['bt_payload']
        );
    }

    /**
     * @param array $parameters
     * @return Message\FindRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\FindRequest', $parameters);
    }


    public function setAuthentication()
    {
        $public_key = '';
        $merchant_id = '';
        $private_key = '';

        $sandbox = \Settings::get('payment_braintree_sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $this->setTestMode(true);
            $merchant_id = \Settings::get('payment_braintree_sandbox_merchant_id');
            $public_key = \Settings::get('payment_braintree_sandbox_public_key');
            $private_key = \Settings::get('payment_braintree_sandbox_private_key');
        } elseif ($sandbox == 'false') {
            $this->setTestMode(false);
            $merchant_id = \Settings::get('payment_braintree_live_merchant_id');
            $public_key = \Settings::get('payment_braintree_live_public_key');
            $private_key = \Settings::get('payment_braintree_live_private_key');
        }
        $this->setMerchantId($merchant_id);
        $this->setPublicKey($public_key);
        $this->setPrivateKey($private_key);
    }

    public function getPlanIntegrationId($plan)
    {
        return $plan->code;

    }

    public function preparePlanParameters(Plan $plan)
    {
        if ($plan->bill_cycle != "month") {
            throw new Exception("Briantree supports monthly plans only");

        }
        return [
            "id" => $plan->code,
            "billingDayOfMonth" => "1",
            "billingFrequency" => "1",
            "currencyIsoCode" => strtoupper($plan->currency),
            "description" => $plan->description,
            "name" => $plan->name,
            "price" => $plan->price,
//            "trialPeriod" => $plan->trial_period,
            "trialDurationUnit" => "day",
            "trialPeriod" => $plan->trial_period > 0 ? "true" : "false",
        ];
    }


    public function prepareCustomerParameters(User $user, $extra = [])
    {

        $customerData = ['firstName' => $user->full_name, 'email' => $user->email];


        if (isset($extra['checkoutToken'])) {
            $customerData['paymentMethodNonce'] = $extra['checkoutToken'];

        } else if ($user->payment_method_token) {
            $customerData['defaultPaymentMethodToken'] = $user->payment_method_token;
        }

        $parameters['customerData'] = $customerData;
        if (!is_null($user->integration_id)) {
            $parameters['customerId'] = $user->integration_id;
        }
        return $parameters;
    }

    public function prepareSubscriptionParameters(Plan $plan, User $user, Subscription $subscription = null, $subscription_data = null)
    {
        $parameters['subscriptionData'] = ['paymentMethodToken' => $user->payment_method_token, 'planId' => $plan->code];
        if ($subscription) {
            $parameters['subscriptionid'] = $subscription->subscription_reference;
        }

        return $parameters;
    }

    /**
     * Update Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\UpdateSubscriptionRequest
     */
    public function updateSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdateSubscriptionRequest', $parameters);
    }

    public function prepareSubscriptionCancellationParameters(User $user, Subscription $current_subscription)
    {

        return $current_subscription->subscription_reference;
    }


    /**
     * @return mixed
     */
    public function webhookNotification()
    {

        $this->configure();
        return $this->WebhookNotificationGateway();
    }


    public function configure()
    {
        // When in testMode, use the sandbox environment
        if ($this->getTestMode()) {
            $this->braintree->config->environment('sandbox');
        } else {
            $this->braintree->config->environment('production');
        }

        // Set the keys
        $this->braintree->config->merchantId($this->getMerchantId());
        $this->braintree->config->publicKey($this->getPublicKey());
        $this->braintree->config->privateKey($this->getPrivateKey());
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public static function webhookHandler(Request $request)
    {


        $subscription = new SubscriptionClass('Braintree');
        $subscription->gateway->configure();


        //$sampleNotification = Braintree_WebhookTesting::sampleNotification(
        //    \Braintree_WebhookNotification::SUBSCRIPTION_CHARGED_SUCCESSFULLY,
        //    'fjk62b'
        //);
        //$notification = $subscription->gateway->parseNotification($sampleNotification);
        //print_r($notification);
        //die();
        //$bt_signature = $sampleNotification['bt_signature'];
        //$bt_payload = $sampleNotification['bt_payload'];

        $bt_signature = $request->get('bt_signature');
        $bt_payload = $request->get('bt_payload');
        $notification = $subscription->gateway->parseNotification(compact('bt_signature', 'bt_payload'));

        $webhookCall = null;

        try {


            $data = [
                'event_name' => 'braintree.' . $notification->kind,
                'payload' => $notification->subject,
                'gateway' => 'Braintree'
            ];

            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'braintree');
        }
    }

    /**
     * @param string $signature
     * @param string $payload
     * @return bool
     * @throws \Exception
     */
    protected static function isValid(string $signature, string $payload): bool
    {
        $subscription = new SubscriptionClass('Braintree');

        $webhook_secret = $subscription->gateway->getApiWebhookKey();

        if (empty($webhook_secret)) {
            throw BraintreeWebhookFailed::signingSecretNotSet();
        }
        try {
            Webhook::constructEvent($payload, $signature, $webhook_secret);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }


    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "Braintree::subscription-checkout";

        } else if ($type == "ecommerce") {
            return "Braintree::ecommerce-checkout";

        }
    }

    public function prepareCreateChargeParameters($order, User $user, $checkoutDetails)
    {
        $parameters = [
            'amount' => $order->amount,
        ];

        if (!is_null($user->integration_id) && !is_null($user->payment_method_token)) {
            $parameters['paymentMethodToken'] = $user->payment_method_token;
        } else {
            $parameters['token'] = $checkoutDetails['token'];
        }

        return $parameters;
    }

    /**
     * create Charge
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Braintree\Message\
     */
    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Braintree\Message\AuthorizeRequest', $parameters);
    }
}
