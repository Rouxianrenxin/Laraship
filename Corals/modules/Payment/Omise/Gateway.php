<?php

namespace Corals\Modules\Payment\Omise;

use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Models\WebhookCall;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Http\Request;

/**
 * Omise Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Omise';
    }

    public function setAuthentication()
    {
        $public_key = '';
        $merchant_id = '';
        $private_key = '';
        $admin_username = '';
        $admin_password = '';

        $sandbox = \Settings::get('payment_omise_sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $this->setTestMode(true);
            $public_key = \Settings::get('payment_omise_sandbox_public_key');
            $private_key = \Settings::get('payment_omise_sandbox_private_key');


        } elseif ($sandbox == 'false') {
            $this->setTestMode(false);
            $public_key = \Settings::get('payment_omise_live_public_key');
            $private_key = \Settings::get('payment_omise_live_private_key');
        }
        $this->setPublicKey($public_key);
        $this->setPrivateKey($private_key);

    }

    public function getDefaultParameters()
    {
        return array(
            // if true, transaction with the live checkout URL will be a demo sale and card won't be charged.
            'demoMode' => false,
            'testMode' => false,
        );
    }

    /**
     * Getter: demo mode.
     *
     * @return string
     */
    public function getDemoMode()
    {
        return $this->getParameter('demoMode');
    }

    /**
     * Setter: demo mode.
     *
     * @param $value
     *
     * @return $this
     */
    public function setDemoMode($value)
    {
        return $this->setParameter('demoMode', $value);
    }

    /**
     * Getter: checkout language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Setter: checkout language.
     *
     * @param $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Getter: purchase step.
     *
     * @param $value
     *
     * @return $this
     */
    public function getPurchaseStep()
    {
        return $this->getParameter('purchaseStep');
    }

    /**
     * Setter: purchase step.
     *
     * @param $value
     *
     * @return $this
     */
    public function setPurchaseStep($value)
    {
        return $this->setParameter('purchaseStep', $value);
    }

    /**
     * Getter: coupon.
     *
     * @return string
     */
    public function getCoupon()
    {
        return $this->getParameter('coupon');
    }

    /**
     * Setter: coupon.
     *
     * @param $value
     *
     * @return $this
     */
    public function setCoupon($value)
    {
        return $this->setParameter('coupon', $value);
    }

    /**
     * Getter: Omise account number.
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * Setter: Omise account number.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAccountNumber($value)
    {
        return $this->setParameter('accountNumber', $value);
    }

    /**
     * Getter: Omise secret word.
     *
     * @return string
     */
    public function getSecretWord()
    {
        return $this->getParameter('secretWord');
    }

    /**
     * Setter: Omise secret word.
     *
     * @param $value
     *
     * @return $this
     */
    public function setSecretWord($value)
    {
        return $this->setParameter('secretWord', $value);
    }

    /**
     * Setter: sale ID for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setSaleId($value)
    {
        return $this->setParameter('saleId', $value);
    }

    /**
     * Getter: sale ID for use by refund.
     *
     * @return string
     */
    public function getSaleId()
    {
        return $this->getParameter('saleId');
    }

    /**
     * Setter: sale ID for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setInvoiceId($value)
    {
        return $this->setParameter('invoiceId', $value);
    }

    /**
     * Getter: sale ID for use by refund.
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
    }


    /**
     * Getter: category for use by refund.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->getParameter('category');
    }

    /**
     * Setter: category for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setCategory($value)
    {
        return $this->setParameter('category', $value);
    }

    /**
     * Getter: comment for use by refund.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getParameter('comment');
    }

    /**
     * Setter: category for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setComment($value)
    {
        return $this->setParameter('comment', $value);
    }

    /**
     * Setter: lineitem_id for use by stop recurring.
     *
     * @param $value
     *
     * @return $this
     */
    public function setLineItemId($value)
    {
        return $this->setParameter('lineItemId', $value);
    }

    /**
     * Getter: lineitem_id for use by stop recurring.
     *
     * @return string
     */
    public function getLineItemId()
    {
        return $this->getParameter('lineItemId');
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return parent::setParameter('amount', $value);
    }

    public function getCurrency()
    {
        return parent::getCurrency();
    }

    public function setCurrency($value)
    {
        return parent::setCurrency($value);
    }

    /**
     * Setter: admin password for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAdminPassword($value)
    {
        return $this->setParameter('adminPassword', $value);
    }


    /**
     * Getter: Omise public key.
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->getParameter('PublicKey');
    }

    /**
     * Setter: Omise public key.
     *
     * @param $value
     *
     * @return $this
     */
    public function setPublicKey($value)
    {
        return $this->setParameter('PublicKey', $value);
    }

    /**
     * Getter: Omise private key.
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * Setter: Omise private key.
     *
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\RefundRequest', $parameters);
    }

    public function fetchSaleDetails(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\DetailSaleRequest', $parameters);
    }

    public function cancelSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\StopRecurringRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * Create Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Omise\Message\TokenPurchaseRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\TokenPurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\NotificationRequest', $parameters);
    }

    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "Omise::subscription-checkout";

        } else if ($type == "ecommerce") {
            return "Omise::ecommerce-checkout";

        }
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

        $parameters['cart'] = [[
            'type' => 'product',
            'name' => $plan->product->name,
            'price' => $plan->price,
            'recurrence' => $plan->bill_frequency . ' ' . ucfirst($plan->bill_cycle),
            'duration' => 'Forever',
        ]];
        $parameters['amount'] = $plan->price;
        $parameters['transactionId'] = $user->id;
        $parameters['token'] = session()->get('checkoutToken');
        $parameters['accountNumber'] = $this->getAccountNumber();
        $parameters['privateKey'] = $this->getPrivateKey();
        $parameters['currency'] = \Payments::admin_currency_code();
        $parameters['billingAddr'] = array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        );
        session()->forget('checkoutToken');


        return $parameters;
    }

    public function prepareSubscriptionCancellationParameters(User $user, Subscription $current_subscription)
    {
        list($sale_id, $line_item_id) = explode('|', $current_subscription->subscription_reference);
        $parameters = [
            'adminUsername' => $this->getAdminUsername(),
            'adminPassword' => $this->getAdminPassword(),
            'lineItemId' => $line_item_id,
        ];

        return $parameters;
    }

    public static function webhookHandler(Request $request)
    {
        try {
            $webhookCall = null;


            $eventPayload = $request->input();
            $data = [
                'event_name' => 'omise.' . $eventPayload['message_type'],
                'payload' => $eventPayload,
                'gateway' => 'Omise'
            ];
            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
            die();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'omise');
        }
    }

    public function prepareCreateChargeParameters($order, User $user, $checkoutDetails)
    {

        return [
            'amount' => $order->amount,
            'currency' => strtolower($order->currency),
            'token' => $checkoutDetails['token'],
            'description' => 'Order #' . $order->id,
        ];
    }

    /**
     * create Charge
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Omise\Message\
     */
    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Omise\Message\CompletePurchaseRequest', $parameters);
    }
}
