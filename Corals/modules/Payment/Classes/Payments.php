<?php

namespace Corals\Modules\Payment\Classes;


use Corals\Modules\Payment\Models\TaxClass;
use Money\Currencies\ISOCurrencies;
use Money\Currency;


class Payments
{
    /**
     * Products constructor.
     */
    function __construct()
    {
    }

    public function getCodeList()
    {
        $codes = \Corals\Modules\Payment\Models\Currency::pluck('code', 'code');
        return $codes;
    }

    public function getAvailableGateways()
    {
        $supported_gateways = \Settings::get('supported_payment_gateway', []);
        return $supported_gateways;
    }

    public function setAvailableGateways($supported_gateways)
    {
        \Settings::set('supported_payment_gateway', json_encode($supported_gateways));

    }


    public function isGatewaySupported($gateway)
    {
        return array_key_exists($gateway, $this->getAvailableGateways());
    }


    public function getTaxClassesList()
    {
        return TaxClass::orderBy('name')->pluck('name', 'id')->toArray();
    }


    /**
     * @param $taxable
     * @param array $address
     * @return array
     * @throws \Exception
     */
    public function calculateTax($taxable, $address = [])
    {
        try {
            $taxes = [];
            foreach ($taxable->tax_classes as $tax_class) {
                //$tax_included = $taxable->tax_inclusive;
                $class_taxes = $tax_class->getTaxByPriority();
                $rate = 0;
                $applied_country = [];
                $applied_state = [];
                $applied_zip = [];
                $state = strtolower($address['state']);
                foreach ($class_taxes as $tax) {


                    $calculate = false;
                    if ($tax->country == '' && !isset($applied_country[$tax->name])) {
                        $calculate = true;
                        $applied_country[$tax->name] = $tax->rate;

                    } else if ($tax->country == $address['country'] && !isset($applied_country[$tax->name])) {

                        if ($tax->state == $state && !isset($applied_state[$tax->name])) {
                            if (($tax->zip == $address['zip'] || $tax->zip == "") && !isset($applied_zip[$tax->name])) {
                                $calculate = true;
                                $applied_country[$tax->name] = $tax->rate;
                                $applied_state[$tax->name] = $tax->rate;
                                $applied_zip[$tax->name] = $tax->rate;
                            }
                        } else if ($tax->state == '' && !isset($applied_state[$tax->name])) {
                            $calculate = true;
                            $applied_country[$tax->name] = $tax->rate;
                            $applied_state[$tax->name] = $tax->rate;
                            $applied_zip[$tax->name] = $tax->rate;
                        }
                    }
                    if ($calculate) {
                        if ($tax->compound == 1) {
                            $rate += $tax->rate;
                            $taxes[$tax->id] = ['name' => $tax->name, 'rate' => ($rate / 100)];
                        } else {
                            $taxes[$tax->id] = ['name' => $tax->name, 'rate' => ($tax->rate / 100)];
                        }
                    }
                }

            }
            return $taxes;
        } catch (\Exception $ex) {
            throw new \Exception(trans('Payment::exception.tax.error_calculating_tax', ['message' => $ex->getMessage()]));
        }
    }

    function currency($amount, $currency = null)
    {
        if (is_null($amount)) {
            $amount = 0;
        }

        if ($currency) {
            return currency()->format($amount, $currency);
        }

        return currency($amount, \Payments::admin_currency_code(), $this->session_currency());
    }

    function session_currency()
    {
        return currency()->getUserCurrency();
    }

    function currency_symbol()
    {
        return currency()->getCurrency()['symbol'];
    }

    function currency_convert($amount, $from = null, $to = null, $format = false)
    {
        if (($from == $to) && ($from != null)) {
            return $amount;
        }
        if (!$from) {
            $from = \Payments::admin_currency_code();
        }
        if (!$to) {
            $to = $this->session_currency();
        }
        $to = strtoupper($to);
        $conversion = currency()->convert($amount, $from, $to, false);
        $iso_currencies = new ISOCurrencies();
        $currency = new Currency($to);
        if ($currency) {
            $decimals = $iso_currencies->subunitFor($currency);
            $amount = number_format((float)$conversion, $decimals, '.', '');
        } else {
            $amount = $conversion;
        }
        if ($format) {
            return currency()->format($amount, $to);
        }
        return $amount;
    }

    function admin_currency($amount)
    {
        return currency()->format($amount, \Payments::admin_currency_code());
    }

    function admin_currency_code($lower_case = false)
    {
        $default_currency = config('currency.default');
        $admin_currency_code = \Settings::get('admin_currency_code', $default_currency);
        if ($lower_case) {
            return strtolower($admin_currency_code);
        } else {
            return strtolower($admin_currency_code);
        }
    }

    function getActiveCurrenciesList()
    {
        $currencies = currency()->getActiveCurrencies();
        $active_currencies = [];
        foreach ($currencies as $currency) {
            $active_currencies[$currency['code']] = $currency['code'] . " " . $currency['symbol'];
        }
        return $active_currencies;
    }

}