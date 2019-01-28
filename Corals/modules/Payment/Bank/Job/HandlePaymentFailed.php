<?php

namespace Corals\Modules\Payment\Bank\Job;


use Carbon\Carbon;
use Corals\Modules\Payment\Bank\Exception\BankWebhookFailed;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Payment\Payment;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Payment\Models\WebhookCall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class HandlePaymentFailed implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Corals\Modules\Payment\Models\WebhookCall
     */
    public $webhookCall;

    /**
     * HandleInvoiceCreated constructor.
     * @param WebhookCall $webhookCall
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }


    public function handle()
    {
        logger('Invoice Created job, webhook_call: ' . $this->webhookCall->id);

        try {

            if ($this->webhookCall->processed) {
                throw BankWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;
            $gateway = Payment::create('Bank');
            $gateway->setAuthentication();
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName($gateway->getApiLoginId());
            $merchantAuthentication->setTransactionKey($gateway->getTransactionKey());

            // Set the transaction's refId
            $refId = 'ref' . time();
            $request = new AnetAPI\GetTransactionDetailsRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setTransId($payload['id']);
            $controller = new AnetController\GetTransactionDetailsController($request);
            $response = $controller->executeWithApiResponse($gateway->getDeveloperMode() ? $gateway->getDeveloperEndpoint() : $gateway->getLiveEndpoint());
            $subscriptionResponse = $response->getTransaction()->getSubscription();
            if ($subscriptionResponse) {

                $subscription = Subscription::where('subscription_reference', $subscriptionResponse->getId() )->first();

                if (!$subscription) {
                    throw BankWebhookFailed::invalidBankSubscription($this->webhookCall);
                }
                $invoice = Invoice::whereCode($payload['id'])->first();

                if (!$invoice) {
                    $invoice = Invoice::create([
                        'code' => $payload['id'],
                        'currency' => \Payments::admin_currency_code(),
                        'description' => $response->getTransaction()->getResponseReasonDescription(),
                        'sub_total' => $payload['authAmount'],
                        'total' => $payload['authAmount'],
                        'user_id' => $subscription->user_id,
                        'invoicable_id' => $subscription->id,
                        'invoicable_type' => Subscription::class,
                        'due_date' => Carbon::parse(new Carbon($response->getTransaction()->getSubmitTimeLocal()->format(DATE_ISO8601)))->format('Y-m-d H:i'),
                    ]);
                }
                $invoice->markAsFailed();
                $this->webhookCall->markAsProcessed();
            } else {
                throw BankWebhookFailed::invalidBankPayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }
    }
}