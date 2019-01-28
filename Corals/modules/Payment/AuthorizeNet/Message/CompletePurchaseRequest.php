<?php

namespace Corals\Modules\Payment\AuthorizeNet\Message;

use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * AuthorizeNet Complete Purchase Request.
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     *
     *
     * @throws InvalidResponseException
     */
    public function getData()
    {

        return $this->getChargeData();

    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($this->getApiLoginId());
        $merchantAuthentication->setTransactionKey($this->getTransactionKey());

        $refId = 'ref' . time();



        $OpaqueData = new AnetAPI\OpaqueDataType();
        $OpaqueData->setDataDescriptor($data['DataDescriptor']);
        $OpaqueData->setDataValue($data['DataValue']);
        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setOpaqueData($OpaqueData);
        //create a transaction

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($data['order_number']);
        $order->setDescription($data['description']);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction"); // TODO Change to Enum
        $transactionRequestType->setAmount($data['amount']);
        $transactionRequestType->setPayment($paymentType);
        $transactionRequestType->setOrder($order);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);
        $request->setRefId($refId);

        $controller = new AnetController\CreateTransactionController($request);


        $response = $controller->executeWithApiResponse($this->getDeveloperMode() ? $this->getDeveloperEndpoint() : $this->getLiveEndpoint());



        return new CompletePurchaseResponse($this, $response);
    }
}
