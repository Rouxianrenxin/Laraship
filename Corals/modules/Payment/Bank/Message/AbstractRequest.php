<?php

namespace Corals\Modules\Payment\Bank\Message;

use Corals\Modules\Payment\Common\Http\ClientInterface;
use Corals\Modules\Payment\Common\Exception\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Corals\Modules\Payment\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * @var \Bank_Gateway
     */
    protected $authorizeNet;

    /**
     * Create a new Request
     *
     * @param ClientInterface $httpClient
     * @param HttpRequest $httpRequest A Symfony HTTP request object
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * Set the correct configuration sending
     *
     * @return \Corals\Modules\Payment\Common\Message\ResponseInterface
     */
    public function send()
    {
        return parent::send();
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

    public function getBillingAddressId()
    {
        return $this->getParameter('billingAddressId');
    }

    public function setBillingAddressId($value)
    {
        return $this->setParameter('billingAddressId', $value);
    }

    public function getChannel()
    {
        return $this->getParameter('channel');
    }

    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    public function getCustomFields()
    {
        return $this->getParameter('customFields');
    }

    public function setCustomFields($value)
    {
        return $this->setParameter('customFields', $value);
    }

    public function getCustomerData()
    {
        return $this->getParameter('customerData');
    }

    public function getSubscriptionData()
    {
        return $this->getParameter('subscriptionData');
    }

    public function getSubscriptionCancellationData()
    {
        return $this->getParameter('SubscriptionCancellationData');
    }

    public function setSubscriptionCancellationData($value)
    {
        return $this->setParameter('SubscriptionCancellationData', $value);
    }


    public function setSubscriptionData($value)
    {
        return $this->setParameter('subscriptionData', $value);
    }

    public function setCustomerData($value)
    {
        return $this->setParameter('customerData', $value);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    public function getDescriptor()
    {
        return $this->getParameter('descriptor');
    }

    public function setDescriptor($value)
    {
        return $this->setParameter('descriptor', $value);
    }

    public function getDeviceData()
    {
        return $this->getParameter('deviceData');
    }

    public function setDeviceData($value)
    {
        return $this->setParameter('deviceData', $value);
    }

    public function getDeviceSessionId()
    {
        return $this->getParameter('deviceSessionId');
    }

    public function setDeviceSessionId($value)
    {
        return $this->setParameter('deviceSessionId', $value);
    }

    public function getMerchantAccountId()
    {
        return $this->getParameter('merchantAccountId');
    }

    public function setMerchantAccountId($value)
    {
        return $this->setParameter('merchantAccountId', $value);
    }

    public function getRecurring()
    {
        return $this->getParameter('recurring');
    }

    public function setRecurring($value)
    {
        return $this->setParameter('recurring', (bool)$value);
    }

    public function getAddBillingAddressToPaymentMethod()
    {
        return $this->getParameter('addBillingAddressToPaymentMethod');
    }

    public function setAddBillingAddressToPaymentMethod($value)
    {
        return $this->setParameter('addBillingAddressToPaymentMethod', (bool)$value);
    }

    public function getHoldInEscrow()
    {
        return $this->getParameter('holdInEscrow');
    }

    public function setHoldInEscrow($value)
    {
        return $this->setParameter('holdInEscrow', (bool)$value);
    }

    public function getServiceFeeAmount()
    {
        $amount = $this->getParameter('serviceFeeAmount');
        if ($amount !== null) {
            if (!is_float($amount) &&
                $this->getCurrencyDecimalPlaces() > 0 &&
                false === strpos((string)$amount, '.')
            ) {
                throw new InvalidRequestException(trans('Bank::exception.please_specify_amount_string'));
            }

            return $this->formatCurrency($amount);
        }
    }

    public function setServiceFeeAmount($value)
    {
        return $this->setParameter('serviceFeeAmount', $value);
    }

    public function getStoreInVault()
    {
        return $this->getParameter('storeInVault');
    }

    public function setStoreInVault($value)
    {
        return $this->setParameter('storeInVault', (bool)$value);
    }

    public function getStoreInVaultOnSuccess()
    {
        return $this->getParameter('storeInVaultOnSuccess');
    }

    public function setStoreInVaultOnSuccess($value)
    {
        return $this->setParameter('storeInVaultOnSuccess', (bool)$value);
    }

    public function getStoreShippingAddressInVault()
    {
        return $this->getParameter('storeShippingAddressInVault');
    }

    public function setStoreShippingAddressInVault($value)
    {
        return $this->setParameter('storeShippingAddressInVault', (bool)$value);
    }

    public function getShippingAddressId()
    {
        return $this->getParameter('shippingAddressId');
    }

    public function setShippingAddressId($value)
    {
        return $this->setParameter('shippingAddressId', $value);
    }

    public function getPurchaseOrderNumber()
    {
        return $this->getParameter('purchaseOrderNumber');
    }

    public function setPurchaseOrderNumber($value)
    {
        return $this->setParameter('purchaseOrderNumber', $value);
    }

    public function getTaxAmount()
    {
        return $this->getParameter('taxAmount');
    }

    public function setTaxAmount($value)
    {
        return $this->setParameter('taxAmount', $value);
    }

    public function getTaxExempt()
    {
        return $this->getParameter('taxExempt');
    }

    public function setTaxExempt($value)
    {
        return $this->setParameter('taxExempt', (bool)$value);
    }

    public function getPaymentMethodToken()
    {
        return $this->getParameter('paymentMethodToken');
    }

    public function setPaymentMethodToken($value)
    {
        return $this->setParameter('paymentMethodToken', $value);
    }

    public function getPaymentMethodNonce()
    {
        return $this->getToken();
    }

    public function setPaymentMethodNonce($value)
    {
        return $this->setToken($value);
    }

    public function getFailOnDuplicatePaymentMethod()
    {
        return $this->getParameter('failOnDuplicatePaymentMethod');
    }

    public function setFailOnDuplicatePaymentMethod($value)
    {
        return $this->setParameter('failOnDuplicatePaymentMethod', (bool)$value);
    }

    public function getMakeDefault()
    {
        return $this->getParameter('makeDefault');
    }

    public function setMakeDefault($value)
    {
        return $this->setParameter('makeDefault', (bool)$value);
    }

    public function getVerifyCard()
    {
        return $this->getParameter('verifyCard');
    }

    public function setVerifyCard($value)
    {
        return $this->setParameter('verifyCard', (bool)$value);
    }

    public function getVerificationMerchantAccountId()
    {
        return $this->getParameter('verificationMerchantAccountId');
    }

    public function setVerificationMerchantAccountId($value)
    {
        return $this->setParameter('verificationMerchantAccountId', $value);
    }

    /**
     * @return array
     */
    public function getCardData()
    {
        $card = $this->getCard();

        if (!$card) {
            return array();
        }

        return array(
            'billing' => array(
                'company' => $card->getBillingCompany(),
                'firstName' => $card->getBillingFirstName(),
                'lastName' => $card->getBillingLastName(),
                'streetAddress' => $card->getBillingAddress1(),
                'extendedAddress' => $card->getBillingAddress2(),
                'locality' => $card->getBillingCity(),
                'postalCode' => $card->getBillingPostcode(),
                'region' => $card->getBillingState(),
                'countryName' => $card->getBillingCountry(),
            ),
            'shipping' => array(
                'company' => $card->getShippingCompany(),
                'firstName' => $card->getShippingFirstName(),
                'lastName' => $card->getShippingLastName(),
                'streetAddress' => $card->getShippingAddress1(),
                'extendedAddress' => $card->getShippingAddress2(),
                'locality' => $card->getShippingCity(),
                'postalCode' => $card->getShippingPostcode(),
                'region' => $card->getShippingState(),
                'countryName' => $card->getShippingCountry(),
            )
        );
    }

    /**
     * @return array
     */
    public function getOptionData()
    {
        $data = array(
            'addBillingAddressToPaymentMethod' => $this->getAddBillingAddressToPaymentMethod(),
            'failOnDuplicatePaymentMethod' => $this->getFailOnDuplicatePaymentMethod(),
            'holdInEscrow' => $this->getHoldInEscrow(),
            'makeDefault' => $this->getMakeDefault(),
            'storeInVault' => $this->getStoreInVault(),
            'storeInVaultOnSuccess' => $this->getStoreInVaultOnSuccess(),
            'storeShippingAddressInVault' => $this->getStoreShippingAddressInVault(),
            'verifyCard' => $this->getVerifyCard(),
            'verificationMerchantAccountId' => $this->getVerificationMerchantAccountId(),
        );

        // Remove null values
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });

        if (empty($data)) {
            return $data;
        } else {
            return array('options' => $data);
        }
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
