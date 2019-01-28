<?php
/**
 * PayPal REST Response
 */

namespace Corals\Modules\Payment\PayPal\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;
use Corals\Modules\Payment\Common\Message\RequestInterface;

/**
 * PayPal REST Response
 */
class RestResponse extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    public function isSuccessful()
    {
        return empty($this->data['error']) && $this->getCode() < 400;
    }

    public function getTransactionReference()
    {
        // This is usually correct for payments, authorizations, etc
        if (!empty($this->data['transactions']) && !empty($this->data['transactions'][0]['related_resources'])) {
            foreach (array('sale', 'authorization') as $type) {
                if (!empty($this->data['transactions'][0]['related_resources'][0][$type])) {
                    return $this->data['transactions'][0]['related_resources'][0][$type]['id'];
                }
            }
        }

        // This is a fallback, but is correct for fetch transaction and possibly others
        if (!empty($this->data['id'])) {
            return $this->data['id'];
        }

        return null;
    }


    public function getChargeReference()
    {
        return $this->getTransactionReference();
    }

    function getPlanId()
    {
        return $this->getTransactionReference();
    }

    function getSubscriptionReference()
    {
        return $this->getTransactionReference();
    }

    function getCurrentPeriodEndReference()
    {
        return \Carbon\Carbon::now()->timestamp;
    }


    public function getMessage()
    {
        if (isset($this->data['error_description'])) {
            return $this->data['error_description'];
        }

        if (isset($this->data['message'])) {
            return $this->data['message'];
        }

        return null;
    }

    public function getSubscriptionTokenReference()
    {
        $token_response = array();
        $link = array();
        //[{"href":"https:\/\/www.sandbox.paypal.com\/cgi-bin\/webscr?cmd=_express-checkout&token=EC-5T880039B2957424R","rel":"approval_url","method":"REDIRECT"},{"href":"https:\/\/api.sandbox.paypal.com\/v1\/payments\/billing-agreements\/EC-5T880039B2957424R\/agreement-execute","rel":"execute","method":"POST"}]

        if (isset($this->data['links'])) {
            foreach ($this->data['links'] as $link) {

                $link_params = parse_url($link['href'], PHP_URL_QUERY);
                parse_str($link_params, $params);
                $token_response[$link['rel']] = ['url' => $link['href'], 'method' => $link['method'], 'params' => $params];
            }
        }

        return response()->json($token_response);
    }

    public function getPaymentTokenReference()
    {
        $token_response = array();
        $link = array();
        //[{"href":"https:\/\/www.sandbox.paypal.com\/cgi-bin\/webscr?cmd=_express-checkout&token=EC-5T880039B2957424R","rel":"approval_url","method":"REDIRECT"},{"href":"https:\/\/api.sandbox.paypal.com\/v1\/payments\/billing-agreements\/EC-5T880039B2957424R\/agreement-execute","rel":"execute","method":"POST"}]

        if (isset($this->data['links'])) {
            foreach ($this->data['links'] as $link) {

                $link_params = parse_url($link['href'], PHP_URL_QUERY);
                parse_str($link_params, $params);
                $token_response[$link['rel']] = ['url' => $link['href'], 'method' => $link['method'], 'params' => $params];
            }
        }

        return response()->json($token_response);
    }

    public function getCode()
    {
        return $this->statusCode;
    }

    public function getCardReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
    }
}
