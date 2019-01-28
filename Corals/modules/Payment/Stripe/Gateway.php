<?php

/**
 * Stripe Gateway.
 */

namespace Corals\Modules\Payment\Stripe;

use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Stripe\Exception\StripeWebhookFailed;
use Corals\Modules\Payment\Stripe\Message\CreateTokenRequest;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Payment\Models\WebhookCall;
use Corals\User\Models\User;
use Illuminate\Http\Request;
use Corals\Modules\Subscriptions\Classes\Subscription as SubscriptionClass;
use Exception;
use Stripe\Webhook;

/**
 * Stripe Gateway.
 *
 * Example:
 *
 * <code>
 *   // Create a gateway for the Stripe Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Payment::create('Stripe');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *       'apiKey' => 'MyApiKey',
 *   ));
 *
 *   // Create a credit card object
 *   // This card can be used for testing.
 *   $card = new CreditCard(array(
 *               'firstName'    => 'Example',
 *               'lastName'     => 'Customer',
 *               'number'       => '4242424242424242',
 *               'expiryMonth'  => '01',
 *               'expiryYear'   => '2020',
 *               'cvv'          => '123',
 *               'email'                 => 'customer@example.com',
 *               'billingAddress1'       => '1 Scrubby Creek Road',
 *               'billingCountry'        => 'AU',
 *               'billingCity'           => 'Scrubby Creek',
 *               'billingPostcode'       => '4999',
 *               'billingState'          => 'QLD',
 *   ));
 *
 *   // Do a purchase transaction on the gateway
 *   $transaction = $gateway->purchase(array(
 *       'amount'                   => '10.00',
 *       'currency'                 => 'USD',
 *       'card'                     => $card,
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Purchase transaction was successful!\n";
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *
 *       $balance_transaction_id = $response->getBalanceTransactionReference();
 *       echo "Balance Transaction reference = " . $balance_transaction_id . "\n";
 *   }
 * </code>
 *
 * Test modes:
 *
 * Stripe accounts have test-mode API keys as well as live-mode
 * API keys. These keys can be active at the same time. Data
 * created with test-mode credentials will never hit the credit
 * card networks and will never cost anyone money.
 *
 * Unlike some gateways, there is no test mode endpoint separate
 * to the live mode endpoint, the Stripe API endpoint is the same
 * for test and for live.
 *
 * Setting the testMode flag on this gateway has no effect.  To
 * use test mode just use your test mode API key.
 *
 * You can use any of the cards listed at https://stripe.com/docs/testing
 * for testing.
 *
 * Authentication:
 *
 * Authentication is by means of a single secret API key set as
 * the apiKey parameter when creating the gateway object.
 *
 * @see \Corals\Modules\Payment\Common\AbstractGateway
 * @see \Corals\Modules\Payment\Stripe\Message\AbstractRequest
 *
 * @link https://stripe.com/docs/api
 *
 * @method \Corals\Modules\Payment\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Corals\Modules\Payment\Common\Message\RequestInterface completePurchase(array $options = array())
 */
class Gateway extends AbstractGateway
{
    const BILLING_PLAN_FREQUENCY_DAY = 'day';
    const BILLING_PLAN_FREQUENCY_WEEK = 'week';
    const BILLING_PLAN_FREQUENCY_MONTH = 'month';
    const BILLING_PLAN_FREQUENCY_YEAR = 'year';


    public function getName()
    {
        return 'Stripe';
    }

    /**
     * Get the gateway parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
        );
    }

    /**
     * Get the gateway API Key.
     *
     * Authentication is by means of a single secret API key set as
     * the apiKey parameter when creating the gateway object.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function getApiPublicKey()
    {
        return $this->getParameter('apiPublicKey');
    }

    public function getApiWebhookKey()
    {
        return $this->getParameter('apiWebhookKey');
    }

    /**
     * Set the gateway API Key.
     *
     * Authentication is by means of a single secret API key set as
     * the apiKey parameter when creating the gateway object.
     *
     * Stripe accounts have test-mode API keys as well as live-mode
     * API keys. These keys can be active at the same time. Data
     * created with test-mode credentials will never hit the credit
     * card networks and will never cost anyone money.
     *
     * Unlike some gateways, there is no test mode endpoint separate
     * to the live mode endpoint, the Stripe API endpoint is the same
     * for test and for live.
     *
     * Setting the testMode flag on this gateway has no effect.  To
     * use test mode just use your test mode API key.
     *
     * @param string $value
     *
     * @return Gateway provides a fluent interface.
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function setApiPublicKey($value)
    {
        return $this->setParameter('apiPublicKey', $value);
    }

    public function setApiWebhookKey($value)
    {
        return $this->setParameter('apiWebhookKey', $value);
    }

    public function setAuthentication()
    {
        $secret_key = '';
        $public_key = '';
        $webhook_key = '';

        $sandbox = \Settings::get('payment_stripe_sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $secret_key = \Settings::get('payment_stripe_sandbox_secret_key');
            $public_key = \Settings::get('payment_stripe_sandbox_public_key');
            $webhook_key = \Settings::get('payment_stripe_sandbox_webhook_key');
        } elseif ($sandbox == 'false') {
            $secret_key = \Settings::get('payment_stripe_live_secret_key');
            $public_key = \Settings::get('payment_stripe_live_public_key');
            $webhook_key = \Settings::get('payment_stripe_live_webhook_key');
        }

        $this->setApiKey($secret_key);
        $this->setApiPublicKey($public_key);
        $this->setApiWebhookKey($webhook_key);
    }

    /**
     * Authorize Request.
     *
     * An Authorize request is similar to a purchase request but the
     * charge issues an authorization (or pre-authorization), and no money
     * is transferred.  The transaction will need to be captured later
     * in order to effect payment. Uncaptured charges expire in 7 days.
     *
     * Either a customerReference or a card is required.  If a customerReference
     * is passed in then the cardReference must be the reference of a card
     * assigned to the customer.  Otherwise, if you do not pass a customer ID,
     * the card you provide must either be a token, like the ones returned by
     * Stripe.js, or a dictionary containing a user's credit card details.
     *
     * IN OTHER WORDS: You cannot just pass a card reference into this request,
     * you must also provide a customer reference if you want to use a stored
     * card.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Capture Request.
     *
     * Use this request to capture and process a previously created authorization.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CaptureRequest', $parameters);
    }

    /**
     * Purchase request.
     *
     * To charge a credit card, you create a new charge object. If your API key
     * is in test mode, the supplied card won't actually be charged, though
     * everything else will occur as if in live mode. (Stripe assumes that the
     * charge would have completed successfully).
     *
     * Either a customerReference or a card is required.  If a customerReference
     * is passed in then the cardReference must be the reference of a card
     * assigned to the customer.  Otherwise, if you do not pass a customer ID,
     * the card you provide must either be a token, like the ones returned by
     * Stripe.js, or a dictionary containing a user's credit card details.
     *
     * IN OTHER WORDS: You cannot just pass a card reference into this request,
     * you must also provide a customer reference if you want to use a stored
     * card.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\PurchaseRequest', $parameters);
    }

    /**
     * Refund Request.
     *
     * When you create a new refund, you must specify a
     * charge to create it on.
     *
     * Creating a new refund will refund a charge that has
     * previously been created but not yet refunded. Funds will
     * be refunded to the credit or debit card that was originally
     * charged. The fees you were originally charged are also
     * refunded.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\RefundRequest', $parameters);
    }

    /**
     * Fetch Transaction Request.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\VoidRequest
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\VoidRequest', $parameters);
    }

    /**
     * @deprecated 2.3.3:3.0.0 duplicate of \Corals\Modules\Payment\Stripe\Gateway::fetchTransaction()
     * @see \Corals\Modules\Payment\Stripe\Gateway::fetchTransaction()
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchChargeRequest
     */
    public function fetchCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchChargeRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchTransactionRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchBalanceTransactionRequest
     */
    public function fetchBalanceTransaction(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchBalanceTransactionRequest', $parameters);
    }


    //
    // Transfers
    // @link https://stripe.com/docs/api#transfers
    //


    /**
     * Transfer Request.
     *
     * To send funds from your Stripe account to a connected account, you create
     * a new transfer object. Your Stripe balance must be able to cover the
     * transfer amount, or you'll receive an "Insufficient Funds" error.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function transfer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\CreateTransferRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function fetchTransfer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\FetchTransferRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function updateTransfer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\UpdateTransferRequest', $parameters);
    }

    /**
     * List Transfers
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest|\Corals\Modules\Payment\Stripe\Message\Transfers\ListTransfersRequest
     */
    public function listTransfers(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\ListTransfersRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function reverseTransfer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\CreateTransferReversalRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function fetchTransferReversal(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\FetchTransferReversalRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function updateTransferReversal(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\UpdateTransferReversalRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function listTransferReversals(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\Transfers\ListTransferReversalsRequest', $parameters);
    }

    //
    // Cards
    // @link https://stripe.com/docs/api#cards
    //

    /**
     * Create Card.
     *
     * This call can be used to create a new customer or add a card
     * to an existing customer.  If a customerReference is passed in then
     * a card is added to an existing customer.  If there is no
     * customerReference passed in then a new customer is created.  The
     * response in that case will then contain both a customer token
     * and a card token, and is essentially the same as CreateCustomerRequest
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\CreateCardRequest
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateCardRequest', $parameters);
    }

    /**
     * Update Card.
     *
     * If you need to update only some card details, like the billing
     * address or expiration date, you can do so without having to re-enter
     * the full card details. Stripe also works directly with card networks
     * so that your customers can continue using your service without
     * interruption.
     *
     * When you update a card, Stripe will automatically validate the card.
     *
     * This requires both a customerReference and a cardReference.
     *
     * @link https://stripe.com/docs/api#update_card
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\UpdateCardRequest
     */
    public function updateCard(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdateCardRequest', $parameters);
    }

    /**
     * Delete a card.
     *
     * This is normally used to delete a credit card from an existing
     * customer.
     *
     * You can delete cards from a customer or recipient. If you delete a
     * card that is currently the default card on a customer or recipient,
     * the most recently added card will be used as the new default. If you
     * delete the last remaining card on a customer or recipient, the
     * default_card attribute on the card's owner will become null.
     *
     * Note that for cards belonging to customers, you may want to prevent
     * customers on paid subscriptions from deleting all cards on file so
     * that there is at least one default card for the next invoice payment
     * attempt.
     *
     * In deference to the previous incarnation of this gateway, where
     * all CreateCard requests added a new customer and the customer ID
     * was used as the card ID, if a cardReference is passed in but no
     * customerReference then we assume that the cardReference is in fact
     * a customerReference and delete the customer.  This might be
     * dangerous but it's the best way to ensure backwards compatibility.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\DeleteCardRequest
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\DeleteCardRequest', $parameters);
    }

    //
    // Customers
    // link: https://stripe.com/docs/api#customers
    //

    /**
     * Create Customer.
     *
     * Customer objects allow you to perform recurring charges and
     * track multiple charges that are associated with the same customer.
     * The API allows you to create, delete, and update your customers.
     * You can retrieve individual customers as well as a list of all of
     * your customers.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\CreateCustomerRequest
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateCustomerRequest', $parameters);
    }

    /**
     * Fetch Customer.
     *
     * Fetches customer by customer reference.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\CreateCustomerRequest
     */
    public function fetchCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchCustomerRequest', $parameters);
    }

    /**
     * Update Customer.
     *
     * This request updates the specified customer by setting the values
     * of the parameters passed. Any parameters not provided will be left
     * unchanged. For example, if you pass the card parameter, that becomes
     * the customer's active card to be used for all charges in the future,
     * and the customer email address is updated to the email address
     * on the card. When you update a customer to a new valid card: for
     * each of the customer's current subscriptions, if the subscription
     * is in the `past_due` state, then the latest unpaid, unclosed
     * invoice for the subscription will be retried (note that this retry
     * will not count as an automatic retry, and will not affect the next
     * regularly scheduled payment for the invoice). (Note also that no
     * invoices pertaining to subscriptions in the `unpaid` state, or
     * invoices pertaining to canceled subscriptions, will be retried as
     * a result of updating the customer's card.)
     *
     * This request accepts mostly the same arguments as the customer
     * creation call.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\CreateCustomerRequest
     */
    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdateCustomerRequest', $parameters);
    }

    /**
     * Delete a customer.
     *
     * Permanently deletes a customer. It cannot be undone. Also immediately
     * cancels any active subscriptions on the customer.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\DeleteCustomerRequest
     */
    public function deleteCustomer(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\DeleteCustomerRequest', $parameters);
    }

    //
    // Tokens
    // @link https://stripe.com/docs/api#tokens
    //

    /**
     * Creates a single use token that wraps the details of a credit card.
     * This token can be used in place of a credit card associative array with any API method.
     * These tokens can only be used once: by creating a new charge object, or attaching them to a customer.
     *
     * This kind of token is also useful when sharing clients between one platform and a connect account.
     * Use this request to create a new token to make a direct charge on a customer of the platform.
     *
     * @param array $parameters parameters to be passed in to the TokenRequest.
     * @return CreateTokenRequest|\Corals\Modules\Payment\Common\Message\AbstractRequest The create token request.
     */
    public function createToken(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateTokenRequest', $parameters);
    }

    /**
     * Stripe Fetch Token Request.
     *
     * Often you want to be able to charge credit cards or send payments
     * to bank accounts without having to hold sensitive card information
     * on your own servers. Stripe.js makes this easy in the browser, but
     * you can use the same technique in other environments with our token API.
     *
     * Tokens can be created with your publishable API key, which can safely
     * be embedded in downloadable applications like iPhone and Android apps.
     * You can then use a token anywhere in our API that a card or bank account
     * is accepted. Note that tokens are not meant to be stored or used more
     * than once—to store these details for use later, you should create
     * Customer or Recipient objects.
     *
     * @param array $parameters
     *
     * @return \Corals\Modules\Payment\Stripe\Message\FetchTokenRequest
     */
    public function fetchToken(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchTokenRequest', $parameters);
    }

    /**
     * Create Plan
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreatePlanRequest
     */
    public function createPlan(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreatePlanRequest', $parameters);
    }

    /**
     * Update Plan
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreatePlanRequest
     */
    public function updatePlan(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdatePlanRequest', $parameters);
    }

    /**
     * Fetch Plan
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchPlanRequest
     */
    public function fetchPlan(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchPlanRequest', $parameters);
    }

    /**
     * Delete Plan
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\DeletePlanRequest
     */
    public function deletePlan(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\DeletePlanRequest', $parameters);
    }

    /**
     * List Plans
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\ListPlansRequest
     */
    public function listPlans(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\ListPlansRequest', $parameters);
    }

    /**
     * Create Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreateSubscriptionRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateSubscriptionRequest', $parameters);
    }

    /**
     * Fetch Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchSubscriptionRequest
     */
    public function fetchSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchSubscriptionRequest', $parameters);
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

    /**
     * Cancel Subscription
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CancelSubscriptionRequest
     */
    public function cancelSubscription(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CancelSubscriptionRequest', $parameters);
    }

    /**
     * Fetch Event
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchEventRequest
     */
    public function fetchEvent(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchEventRequest', $parameters);
    }

    public function createInvoice(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateInvoiceRequest', $parameters);
    }

    public function payInvoice(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\PayInvoiceRequest', $parameters);
    }

    /**
     * Fetch Invoice Lines
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchInvoiceLinesRequest
     */
    public function fetchInvoiceLines(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchInvoiceLinesRequest', $parameters);
    }

    /**
     * Fetch Invoice
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchInvoiceRequest
     */
    public function fetchInvoice(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchInvoiceRequest', $parameters);
    }

    /**
     * List Invoices
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\ListInvoicesRequest
     */
    public function listInvoices(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\ListInvoicesRequest', $parameters);
    }

    /**
     * Create Invoice Item
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreateInvoiceItemRequest
     */
    public function createInvoiceItem(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateInvoiceItemRequest', $parameters);
    }

    /**
     * Fetch Invoice Item
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\FetchInvoiceItemRequest
     */
    public function fetchInvoiceItem(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchInvoiceItemRequest', $parameters);
    }

    /**
     * Delete Invoice Item
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\DeleteInvoiceItemRequest
     */
    public function deleteInvoiceItem(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\DeleteInvoiceItemRequest', $parameters);
    }

    /**
     * Create Product
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreateProductRequest
     */
    public function createProduct(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateProductRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function fetchProduct(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\FetchProductRequest', $parameters);
    }


    /**
     * Update Product
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\UpdateProductRequest
     */
    public function updateProduct(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdateProductRequest', $parameters);
    }

    /**
     * Delete Product
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\DeleteProductRequest
     */
    public function deleteProduct(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\DeleteProductRequest', $parameters);
    }

    /**
     * Create SKU
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreateSKURequest
     */
    public function createSKU(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateSKURequest', $parameters);
    }

    /**
     * Update SKU
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\UpdateSKURequest
     */
    public function updateSKU(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdateSKURequest', $parameters);
    }

    /**
     * Delete SKU
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\DeleteSKURequest
     */
    public function deleteSKU(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\DeleteSKURequest', $parameters);
    }

    /**
     * Create Order
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\CreateOrderRequest
     */
    public function createOrder(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateOrderRequest', $parameters);
    }

    /**
     * Update Order
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\UpdateOrderRequest
     */
    public function updateOrder(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\UpdateOrderRequest', $parameters);
    }

    /**
     * Pay Order
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\PayOrderRequest
     */
    public function payOrder(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\PayOrderRequest', $parameters);
    }

    /**
     * create Charge
     *
     * @param array $parameters
     * @return \Corals\Modules\Payment\Stripe\Message\createChargeRequest
     */
    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Stripe\Message\CreateChargeRequest', $parameters);
    }


    public function prepareSKUParameters(SKU $sku)
    {
        return [
            'id' => $sku->code,
            'currency' => strtolower($sku->currency),
            'price' => intval($sku->price * 100),
            'product' => $this->getGatewayIntegrationId($sku->product),
            'attributes' => $sku->propertiesList(),
            'inventory' => ['type' => $sku->inventory],
            'active' => $sku->status == 'active' ? 'true' : 'false'
        ];
    }

    public function prepareProductParameters($product)
    {
        $paramters = [
            'name' => $product->name,
            'attributes' => $product->properties,
            'caption' => $product->caption,
            'description' => $product->description,
            'shippable' => 'false',
            'active' => $product->status == 'active' ? 'true' : 'false'
        ];
        if ($this->getGatewayIntegrationId($product)) {
            $paramters['id'] = $this->getGatewayIntegrationId($product);
        }
        return $paramters;
    }

    public function prepareOrderParameters($order, $user, $cartItems = [], $shipping_rate)
    {
        $items = [];
        foreach ($cartItems as $cartItem) {
            $items[] = [
                'currency' => \Payments::admin_currency_code(true),
                'type' => 'sku',
                'parent' => $cartItem->id->code,
                'quantity' => $cartItem->qty,

            ];
        }
        if ($shipping_rate) {
            $items[] = [
                'currency' => $shipping_rate['currency'],
                'type' => 'shipping',
                'amount' => intval($shipping_rate['amount']),
                'description' => $shipping_rate['description'],

            ];
        }
        $shipping = session()->get('shipping');
        return [
            'id' => $order ? $order->id : '',
            'currency' => \Payments::admin_currency_code(true),
            'customer_id' => $user->integration_id,
            'items' => $items,
            'email' => $user->email,
            'selected_shipping_method' => session()->get('selected_shipping_method'),
            "shipping" => array(
                "name" => $user->full_name,
                "address" => array(
                    "line1" => $shipping['address_1'],
                    "city" => $shipping['city'],
                    "state" => $shipping['state'],
                    "country" => $shipping['country'],
                    "postal_code" => $shipping['zip'],
                )
            ),
        ];
    }


    public function prepareOrderPayParameters($order, User $user, $cardDetails)
    {
        $parameters = ['id' => $order->id, 'source' => $cardDetails['token'], 'email' => $user->email];

        return $parameters;
    }

    public function prepareCustomerParameters(User $user, $extra = [])
    {
        $parameters = ['description' => $user->full_name, 'email' => $user->email];

        if (!is_null($user->integration_id)) {
            $parameters['customerReference'] = $user->integration_id;
        }
        if (isset($extra['checkoutToken'])) {
            $parameters['token'] = $extra['checkoutToken'];
        }

        return $parameters;
    }

    public function preparePlanParameters(Plan $plan)
    {
        return [
            'id' => $plan->code,
            'amount' => ($plan->price * 100),
            'currency' => strtolower($plan->currency),
            'interval' => $plan->bill_cycle,
            'interval_count' => $plan->bill_frequency,
            'trial_period_days' => $plan->trial_period,
            'statement_descriptor' => str_limit($plan->description, 19),
            'name' => $plan->name
        ];
    }

    public function prepareCreateChargeParameters($order, User $user, $checkoutDetails)
    {
        return [
            'amount' => $order->amount,
            'currency' => $order->currency,
            'source' => $checkoutDetails['token'],
            'receipt_email' => $user->email,
            'description' => 'Order #' . $order->id,
        ];
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
        return [
            'amount' => $amount,
            'currency' => $currency,
            'source' => $checkoutDetails['token'],
            'receipt_email' => $user->email,
            'description' => $description,
        ];
    }

    public function prepareInvoiceParameters($user, $plan)
    {
        return ['customerReference' => $user->integration_id];
    }

    public function prepareSubscriptionParameters(Plan $plan, User $user, Subscription $subscription = null, $subscription_data = null)
    {
        $parameters = ['customerReference' => $user->integration_id, 'plan' => $plan->code];
        if ($subscription) {
            $parameters['trial_end'] = $subscription->trial_ends_at ? $subscription->trial_ends_at->getTimestamp() : 'now';
            $parameters['subscriptionReference'] = $subscription->subscription_reference;

        }
        return $parameters;
    }

    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return 'Stripe::card';
        } else  {
            return 'Stripe::ecommerce';
        }
    }

    public static function webhookHandler(Request $request)
    {
        try {
            $webhookCall = null;

            $signature = $request->header('Stripe-Signature');

            if (!$signature) {
                throw StripeWebhookFailed::missingSignature();
            }

            if (!static::isValid($signature, $request->getContent())) {
                throw StripeWebhookFailed::invalidSignature($signature);
            }

            $eventPayload = $request->input();

            $data = [
                'event_name' => 'stripe.' . $eventPayload['type'],
                'payload' => $eventPayload,
                'gateway' => 'Stripe'
            ];

            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'stripe');
        }
    }

    /**
     * @param string $signature
     * @param string $payload
     * @return bool
     * @throws Exception
     */
    protected static function isValid(string $signature, string $payload): bool
    {
        $subscription = new SubscriptionClass('Stripe');

        $webhook_secret = $subscription->gateway->getApiWebhookKey();

        if (empty($webhook_secret)) {
            throw StripeWebhookFailed::signingSecretNotSet();
        }
        try {
            Webhook::constructEvent($payload, $signature, $webhook_secret);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    public function getPlanIntegrationId($plan)
    {
        return $plan->code;
    }


    public function prepareSubscriptionCancellationParameters(User $user, Subscription $current_subscription)
    {
        $parameters = [
            'customerReference' => $user->integration_id,
            'subscriptionReference' => $current_subscription->subscription_reference,
            'atPeriodEnd' => true
        ];

        return $parameters;
    }

    function userRequirePayment(User $user)
    {
        if (is_null($user->integration_id)) {
            return true;

        }
        return false;
    }

}
