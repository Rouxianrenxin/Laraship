<?php

namespace Corals\Modules\Payment\TwoCheckout\Message;


/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class DetailSaleRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://www.2checkout.com/api/sales/detail_sale';
    protected $testEndpoint = 'https://sandbox.2checkout.com/api/sales/detail_sale';

    /**
     * Get appropriate 2checkout endpoints.
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * HTTP request headers.
     *
     * @return array
     */
    public function getRequestHeaders()
    {
        return array(
            'Accept' => 'application/json',
        );
    }

    public function isNotNull($value)
    {
        return !is_null($value);
    }

    public function getData()
    {
        $this->validate('adminUsername', 'adminPassword');

        $data = array();
        $data['admin_username'] = $this->getAdminUsername();
        $data['admin_password'] = $this->getAdminPassword();

        $data['sale_id'] = $this->getSaleId();
        $data['invoice_id'] = $this->getInvoiceId();

        // needed to determine which API endpoint to use in OffsiteResponse
        if ($this->getTestMode()) {
            $data['sandbox'] = true;
        }

        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });

        // remove unwanted data
        unset($data['sandbox']);

        return $data;
    }


    /**
     * @param mixed $data
     *
     * @return DetailSaleResponse
     */
    public function sendData($data)
    {
        $payload = $data;
        unset($payload['admin_username']);
        unset($payload['admin_password']);

        $query = '';
        if (!empty($payload['invoice_id'])) {
            $query = '?invoice_id=' . $payload['invoice_id'];
        }

        if (!empty($payload['sale_id'])) {
            $query = '?sale_id=' . $payload['sale_id'];
        }
        $credentials = base64_encode($data['admin_username'] . ":" . $data['admin_password']);

        $headers = array_merge($this->getRequestHeaders(), ['Authorization' => 'Basic ' . $credentials]);
        $response = $this->httpClient->request('GET',
            $this->getEndpoint() . $query,
            $headers
        );
        return new DetailSaleResponse($this, json_decode($response->getBody()->getContents(), true));


    }
}
