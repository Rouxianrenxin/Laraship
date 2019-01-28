<?php

/**
 * SecurionPay Abstract Request.
 */

namespace Corals\Modules\Payment\SecurionPay\Message;

use Money\Currency;
use Money\Money;
use Money\Number;
use Money\Parser\DecimalMoneyParser;
use Corals\Modules\Payment\Common\Exception\InvalidRequestException;

/**
 * SecurionPay Abstract Request.
 *
 * This is the parent class for all SecurionPay requests.
 *
 * Test modes:
 *
 * SecurionPay accounts have test-mode API keys as well as live-mode
 * API keys. These keys can be active at the same time. Data
 * created with test-mode credentials will never hit the credit
 * card networks and will never cost anyone money.
 *
 * Unlike some gateways, there is no test mode endpoint separate
 * to the live mode endpoint, the SecurionPay API endpoint is the same
 * for test and for live.
 *
 * Setting the testMode flag on this gateway has no effect.  To
 * use test mode just use your test mode API key.
 *
 * You can use any of the cards listed at https://securionpay.com/docs/testing
 * for testing.
 *
 * @see \Corals\Modules\Payment\SecurionPay\Gateway
 * @link https://securionpay.com/docs/api
 */
abstract class AbstractRequest extends \Corals\Modules\Payment\Common\Message\AbstractRequest
{
    /**
     * Live or Test Endpoint URL.
     *
     * @var string URL
     */
    protected $endpoint = 'https://api.securionpay.com';

    /**
     * Get the gateway API Key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set the gateway API Key.
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @deprecated
     */
    public function getCardToken()
    {
        return $this->getCardReference();
    }

    /**
     * @deprecated
     */
    public function setCardToken($value)
    {
        return $this->setCardReference($value);
    }

    /**
     * Get the customer reference.
     *
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->getParameter('customerReference');
    }

    /**
     * Set the customer reference.
     *
     * Used when calling CreateCard on an existing customer.  If this
     * parameter is not set then a new customer is created.
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setCustomerReference($value)
    {
        return $this->setParameter('customerReference', $value);
    }

    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    public function setMetadata($value)
    {
        return $this->setParameter('metadata', $value);
    }

    /**
     * Connect only
     *
     * @return mixed
     */
    public function getConnectedSecurionPayAccountHeader()
    {
        return $this->getParameter('connectedSecurionPayAccount');
    }

    /**
     * @param string $value
     *
     * @return AbstractRequest
     */
    public function setConnectedSecurionPayAccountHeader($value)
    {
        return $this->setParameter('connectedSecurionPayAccount', $value);
    }

    /**
     * Connect only
     *
     * @return mixed
     */
    public function getIdempotencyKeyHeader()
    {
        return $this->getParameter('idempotencyKey');
    }

    /**
     * @param string $value
     *
     * @return AbstractRequest
     */
    public function setIdempotencyKeyHeader($value)
    {
        return $this->setParameter('idempotencyKey', $value);
    }

    abstract public function getEndpoint();

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = array();

        if ($this->getConnectedSecurionPayAccountHeader()) {
            $headers['SecurionPay-Account'] = $this->getConnectedSecurionPayAccountHeader();
        }

        if ($this->getIdempotencyKeyHeader()) {
            $headers['Idempotency-Key'] = $this->getIdempotencyKeyHeader();
        }

        return $headers;
    }

    /**
     * @param mixed $data
     * @return \Corals\Modules\Payment\Common\Message\ResponseInterface|Response
     * @throws \Psr\Http\Client\Exception\NetworkException
     * @throws \Psr\Http\Client\Exception\RequestException
     */
    public function sendData($data)
    {
        $headers = array('Authorization' => 'Basic ' . base64_encode($this->getApiKey() . ':'));
        $body = $data ? http_build_query($data, '', '&') : null;
        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $body);

        return $this->createResponse($httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }


    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParameter('source');
    }

    /**
     * @param $value
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setSource($value)
    {
        return $this->setParameter('source', $value);
    }

    /**
     * @param string $parameterName
     *
     * @return null|Money
     * @throws InvalidRequestException
     */
    public function getMoney($parameterName = 'amount')
    {
        $amount = $this->getParameter($parameterName);

        if ($amount instanceof Money) {
            return $amount;
        }

        if ($amount !== null) {
            $moneyParser = new DecimalMoneyParser($this->getCurrencies());
            $currencyCode = $this->getCurrency() ?: 'USD';
            $currency = new Currency($currencyCode);

            $number = Number::fromString($amount);

            // Check for rounding that may occur if too many significant decimal digits are supplied.
            $decimal_count = strlen($number->getFractionalPart());
            $subunit = $this->getCurrencies()->subunitFor($currency);
            if ($decimal_count > $subunit) {
                throw new InvalidRequestException(trans('SecurionPay::exception.amount_is_too_high'));
            }

            $money = $moneyParser->parse((string)$number, $currency->getCode());

            // Check for a negative amount.
            if (!$this->negativeAmountAllowed && $money->isNegative()) {
                throw new InvalidRequestException(trans('SecurionPay::exception.negative_not_allowed'));
            }

            // Check for a zero amount.
            if (!$this->zeroAmountAllowed && $money->isZero()) {
                throw new InvalidRequestException(trans('SecurionPay::exception.zero_amount_not_allowed'));
            }

            return $money;
        }
    }

    /**
     * @return array
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidCreditCardException
     */
    protected function getCardData()
    {
        $card = $this->getCard();
        $card->validate();

        $data = array();
        $data['objectType'] = 'card';
        $data['number'] = $card->getNumber();
        $data['exp_month'] = $card->getExpiryMonth();
        $data['exp_year'] = $card->getExpiryYear();
        if ($card->getCvv()) {
            $data['cvc'] = $card->getCvv();
        }
        $data['name'] = $card->getName();
        $data['address_line1'] = $card->getAddress1();
        $data['address_line2'] = $card->getAddress2();
        $data['address_city'] = $card->getCity();
        $data['address_zip'] = $card->getPostcode();
        $data['address_state'] = $card->getState();
        $data['address_country'] = $card->getCountry();
        $data['email'] = $card->getEmail();

        return $data;
    }
}