<?php

namespace Corals\Modules\Payment\Common\Hooks;



class Payment
{
    /**
     * Subscription constructor.
     */
    function __construct()
    {
    }


    public function show_available_currencies_menu()
    {

        $active_currencies = currency()->getActiveCurrencies();
        if (count($active_currencies) <= 1) {
            return;
        }

        $menu = '<li class="nav-currency" >';
        foreach ($active_currencies as $currency) {
            $menu .= '<a class="label nav-link badge text-white ';
            $class = strtolower(session('currency')) == strtolower($currency['code']) ? 'label-primary badge-success' : 'label-default badge-secondary';
            $menu .= $class . '" style = "font-size: 100%;font-weight: 400;"  href = "' . request()->url() . '?currency=' . $currency['code'] . '" >' . $currency['symbol'] . '</a>&nbsp;';
        }
        $menu .= '</li >';

        echo $menu;
    }

    public function show_nav_currencies_menu()
    {
        $active_currencies = currency()->getActiveCurrencies();
        if (count($active_currencies) <= 1) {
            return;
        }

        $menu = '<div class="nav-currency" >';
        foreach ($active_currencies as $currency) {
            $menu .= '<a class="label nav-link  text-white badge ';
            $class = strtolower(session('currency')) == strtolower($currency['code']) ? 'label-primary badge-primary' : 'label-default badge-default ';
            $menu .= $class . '" style = "font-size: 100%;font-weight: 400;"  href = "' . request()->url() . '?currency=' . $currency['code'] . '" >' . $currency['symbol'] . '</a>&nbsp;';
        }
        $menu .= '</div >';

        echo $menu;
    }
}

