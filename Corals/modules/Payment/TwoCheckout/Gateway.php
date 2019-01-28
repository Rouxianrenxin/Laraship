<?php

namespace Corals\Modules\Payment\TwoCheckout;

use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Models\WebhookCall;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Http\Request;

/**
 * 2Checkout Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'TwoCheckout';
    }

    public function setAuthentication()
    {
        $public_key = '';
        $merchant_id = '';
        $private_key = '';
        $admin_username = '';
        $admin_password = '';

        $sandbox = \Settings::get('payment_twocheckout_sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $this->setTestMode(true);
            $merchant_id = \Settings::get('payment_twocheckout_sandbox_merchant_id');
            $public_key = \Settings::get('payment_twocheckout_sandbox_public_key');
            $private_key = \Settings::get('payment_twocheckout_sandbox_private_key');
            $admin_username = \Settings::get('payment_twocheckout_sandbox_admin_username');
            $admin_password = \Settings::get('payment_twocheckout_sandbox_admin_password');


        } elseif ($sandbox == 'false') {
            $this->setTestMode(false);
            $merchant_id = \Settings::get('payment_twocheckout_live_merchant_id');
            $public_key = \Settings::get('payment_twocheckout_live_public_key');
            $private_key = \Settings::get('payment_twocheckout_live_private_key');
            $admin_username = \Settings::get('payment_twocheckout_live_admin_username');
            $admin_password = \Settings::get('payment_twocheckout_live_admin_password');
        }
        $this->setAccountNumber($merchant_id);
        $this->setPublicKey($public_key);
        $this->setPrivateKey($private_key);
        $this->setAdminUsername($admin_username);
        $this->setAdminPassword($admin_password);
    }

    public function getDefaultParameters()
    {
        return array(
            'accountNumber' => '',
            'secretWord' => '',
            // if true, transaction with the live checkout URL will be a demo sale and card won't be charged.
            'demoMode' => false,
            'testMode' => false,
        );
    }

    /**
     * Getter: get cart items.
     *
     * @return array
     */
    public function getCart()
    {
        return $this->getParameter('cart');
    }

    /**
     * Array of cart items.
     *
     * format:
     * $gateway->setCart(array(
     * array(
     * 'type'        => 'product',
     * 'name'        => 'Product 1',
     * 'description' => 'Description of product 1',
     * 'quantity'    => 2,
     * 'price'       => 22,
     * 'tangible'    => 'N',
     * 'product_id'  => 12345,
     * 'recurrence'  => '1 Week',
     * 'duration'    => '1 Year',
     * 'startup_fee' => '5',
     * ),
     * array(
     * 'type'     => 'product',
     * 'name'     => 'Product 2',
     * 'quantity' => 1,
     * 'price'    => 10,
     * 'tangible' => 'N'
     * 'product_id'  => 45678,
     * 'recurrence'  => '2 Week',
     * 'duration'    => '1 Year',
     * 'startup_fee' => '3',
     * )
     * ));
     *
     * @param array $value
     *
     * @return $this
     */
    public function setCart($value)
    {
        return $this->setParameter('cart', $value);
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
     * Getter: 2Checkout account number.
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    /**
     * Setter: 2Checkout account number.
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
     * Getter: 2Checkout secret word.
     *
     * @return string
     */
    public function getSecretWord()
    {
        return $this->getParameter('secretWord');
    }

    /**
     * Setter: 2Checkout secret word.
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
     * Getter: admin username for use by refund.
     *
     * @return string
     */
    public function getAdminUsername()
    {
        return $this->getParameter('adminUsername');
    }

    /**
     * Setter: admin username for use by refund.
     *
     * @param $value
     *
     * @return $this
     */
    public function setAdminUsername($value)
    {
        return $this->setParameter('adminUsername', $value);
    }

    /**
     * Getter: admin password for use by refund.
     *
     * @return string
     */
    public function getAdminPassword()
    {
        return $this->getParameter('adminPassword');
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
     * Getter: 2Checkout public key.
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->getParameter('PublicKey');
    }

    /**
     * Setter: 2Checkout public key.
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
     * Getter: 2Checkout private key.
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * Setter: 2Checkout private key.
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
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\RefundRequest', $parameters);
    }

    public function fetchSaleDetails(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\DetailSaleRequest', $parameters);
    }

    public function cancelSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\StopRecurringRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * Create Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\TwoCheckout\Message\TokenPurchaseRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\TokenPurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\TwoCheckout\Message\NotificationRequest', $parameters);
    }

    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "TwoCheckout::subscription-checkout";

        } else if ($type == "ecommerce") {
            return "TwoCheckout::ecommerce-checkout";

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
                'event_name' => 'twocheckout.' . $eventPayload['message_type'],
                'payload' => $eventPayload,
                'gateway' => 'TwoCheckout'
            ];
            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
            die();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'twocheckout');
        }
    }
}
