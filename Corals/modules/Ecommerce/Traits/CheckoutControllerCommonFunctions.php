<?php

namespace Corals\Modules\Ecommerce\Traits;

use Corals\Modules\Payment\Payment;
use Illuminate\Http\Request;
use Corals\Modules\Ecommerce\Classes\Coupons\Advanced;
use Corals\Modules\Ecommerce\Http\Requests\CheckoutRequest;
use Corals\Modules\Ecommerce\Models\Coupon;
use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Ecommerce\Classes\Ecommerce;
use Corals\User\Models\User;

trait CheckoutControllerCommonFunctions
{
    /**
     * CartController constructor.
     */
    protected $shipping;

    /**
     * @param $step
     * @param Request $request
     * @return bool|string
     * @throws \Throwable
     */
    public function checkoutStep($step, Request $request)
    {
        $this->canAccessCheckout();

        try {
            switch ($step) {
                case 'cart-details':
                    $coupon_code = \ShoppingCart::getAttribute('coupon_code');

                    return view('Ecommerce::checkout.partials.cart_items')->with(compact('coupon_code'))->render();
                case 'billing-shipping-address':
                    $enable_shipping = \ShoppingCart::getAttribute('enable_shipping');

                    $billing_address = \ShoppingCart::getAttribute('billing_address') ?? [];
                    if (!$billing_address) {
                        if (user()->address('billing')) {
                            $billing_address = user()->address('billing');
                        }
                    }

                    $shipping_address = \ShoppingCart::getAttribute('shipping_address') ?? [];

                    if (!$shipping_address) {
                        if (user()->address('shipping')) {
                            $shipping_address = user()->address('shipping');

                        }
                    }

                    return view('Ecommerce::checkout.partials.address')->with(compact('shipping_address', 'enable_shipping', 'billing_address'))->render();
                case 'select-payment':
                    $gateway = null;
                    $gateway_name = $request->get('gateway_name');
                    $billing = [];
                    $enable_shipping = \ShoppingCart::getAttribute('enable_shipping');
                    $billing_address = \ShoppingCart::getAttribute('billing_address');
                    $coupon_code = \ShoppingCart::getAttribute('coupon_code');

                    $cart = \ShoppingCart::getItems();
                    $user = user();
                    $billing['billing_address'] = $billing_address;

                    if (\ShoppingCart::getAttribute('order_id')) {
                        $order = Order::find(\ShoppingCart::getAttribute('order_id'));

                        $order->items()->delete();

                        $order->update([
                            'amount' => \ShoppingCart::total(false),
                            'billing' => $billing,
                            'currency' => \Payments::session_currency(),
                            'status' => 'Pending',
                        ]);
                    } else {
                        $order = Order::create([
                            'amount' => \ShoppingCart::total(false),
                            'currency' => \Payments::session_currency(),
                            'order_number' => \Ecommerce::createOrderNumber(),
                            'billing' => $billing,
                            'status' => 'pending',
                            'user_id' => $user->id,
                        ]);

                        \ShoppingCart::setAttribute('order_id', $order->id);
                    }

                    $items = [];

                    foreach ($cart as $item) {
                        $items[] = [
                            'amount' => $item->id->price,
                            'quantity' => $item->qty,
                            'description' => $item->id->product->name . ' - ' . $item->id->code,
                            'sku_code' => $item->id->code,
                            'type' => 'Product',
                            'item_options' => ['product_options' => $item->product_options]
                        ];
                    }


                    if ($enable_shipping) {
                        $shipping_rates = \ShoppingCart::getAttribute('shipping_rates');
                        $selected_shipping_method = \ShoppingCart::getAttribute('selected_shipping_method');
                        $selected_shipping = $shipping_rates[$selected_shipping_method];
                        $shipping_description = $selected_shipping['provider'] . ' - ' . $selected_shipping['service'] . ' Shipping';
                        $items[] = [
                            'amount' => $selected_shipping['amount'],
                            'quantity' => 1,
                            'description' => $shipping_description,
                            'sku_code' => $selected_shipping_method,
                            'type' => 'Shipping',
                        ];
                        if (\ShoppingCart::getAttribute('shipping_description')) {

                            \ShoppingCart::removeFee(\ShoppingCart::getAttribute('shipping_description'));
                        }

                        \ShoppingCart::addFee($shipping_description, $selected_shipping['amount']);
                        \ShoppingCart::setAttribute('shipping_description', $shipping_description);

                        $order->amount = \ShoppingCart::total(false);
                        $order->save();
                    }

                    $order_tax = \ShoppingCart::taxTotal(false);

                    if ($order_tax) {
                        $items[] = [
                            'amount' => $order_tax,
                            'quantity' => 1,
                            'description' => 'Sales Tax',
                            'sku_code' => 'tax',
                            'type' => 'Tax',
                        ];
                    }

                    $discount = \ShoppingCart::totalDiscount(false);

                    if ($discount > 0) {
                        $coupon_code;
                        $items[] = [
                            'amount' => -1 * $discount,
                            'quantity' => 1,
                            'description' => 'Discount Coupon ',
                            'sku_code' => $coupon_code,
                            'type' => 'Discount',
                        ];
                    }

                    $order->items()->createMany($items);

                    if (!$gateway_name) {
                        $available_gateways = \Payments::getAvailableGateways();
                        foreach ($available_gateways as $gateway_key => $available_gateway) {
                            $ecommerce = new Ecommerce($gateway_key);
                            if (!$ecommerce->gateway->getConfig('support_ecommerce')) {
                                unset($available_gateways[$gateway_key]);
                            }
                        }
                        if (count($available_gateways) == 1) {
                            $gateway_name = key($available_gateways);
                        }
                    }

                    //save amount again after addons calculations
                    $order->amount = \ShoppingCart::total(false);
                    $order->save();

                    if ($gateway_name) {
                        $ecommerce = new Ecommerce($gateway_name);
                        $gateway = $ecommerce->gateway;
                    }

                    return view('Ecommerce::checkout.partials.payment')->with(compact('gateway', 'available_gateways', 'order'))->render();
                    break;
                case 'shipping-method':
                    $shipping_address = \ShoppingCart::getAttribute('shipping_address');
                    $cart = \ShoppingCart::getItems();
                    $order_total = \ShoppingCart::total(false);

                    $shipping_rates = \Shipping::getAvailableShippingMethods($shipping_address, $cart, $order_total);

                    \ShoppingCart::setAttribute('shipping_rates', $shipping_rates);

                    $shipping_methods = [];

                    if (is_array($shipping_rates)) {
                        foreach ($shipping_rates as $key => $rate) {
                            $label = $rate['provider'];
                            if ($rate['service']) {
                                $label .= " " . $rate['service'];
                            }
                            if ($rate['amount']) {
                                $label .= ' : <span class="text-info">' . currency()->format($rate['amount'], $rate['currency']) . '</span>';
                            }
                            if ($rate['estimated_days']) {
                                $label .= ', Estimated Delivery : <span class="text-info">' . $rate['estimated_days'] . ' Day(s) </span>';
                            }
                            if ($rate['description']) {
                                $label .= '<br><small>' . $rate['description'] . '</small>';
                            }
                            $shipping_methods[$key] = $label;
                        }
                    }
                    
                    return view('Ecommerce::checkout.partials.shipping_methods')->with(['shipping_methods' => $shipping_methods])->render();
                    break;
                case 'order-review':
                    $order = Order::find(\ShoppingCart::getAttribute('order_id'));
                    return view('Ecommerce::checkout.partials.order_review')->with(['order' => $order])->render();
                    break;
                default:
                    return false;
            }
        } catch (\Exception $exception) {
            log_exception($exception, 'CheckOutController', 'checkoutStep', null, true);
        }
    }

    public function saveCheckoutStep($step, CheckoutRequest $request)
    {
        $cart = \ShoppingCart::getItems();
        try {
            if ($step == "cart-details") {
                \ShoppingCart::removeAttribute('coupon_code');
                \ShoppingCart::removeCoupons();

                if ($request->input('coupon_code')) {
                    $coupon_code = $request->input('coupon_code');
                    $coupon = Coupon::where('code', $coupon_code)->first();
                    if (!$coupon) {
                        throw new \Exception(trans('Ecommerce::exception.checkout.invalid_coupon'));
                    }
                    $coupon_class = new Advanced($coupon_code, $coupon, []);
                    $coupon_class->validate(true);

                    \ShoppingCart::addCoupon($coupon_class);

                    \ShoppingCart::setAttribute('coupon_code', $coupon_code);
                }
            } else if ($step == "billing-shipping-address") {
                $shipping_address = $request->input('shipping_address');
                $billing_address = $request->input('billing_address');

                if (\Settings::get('ecommerce_tax_calculate_tax')) {
                    if ($shipping_address) {
                        $this->calculateCartTax($shipping_address);
                    } else if ($billing_address) {
                        $this->calculateCartTax($billing_address);
                    }
                }

                if ($request->input('save_billing')) {
                    user()->saveAddress($billing_address, 'billing');
                }
                if ($request->input('save_shipping')) {
                    user()->saveAddress($shipping_address, 'shipping');
                }

                \ShoppingCart::setAttribute('billing_address', $billing_address);
                \ShoppingCart::setAttribute('shipping_address', $shipping_address);
            } else if ($step == "select-payment") {
                $checkoutToken = $request->input('checkoutToken');
                $gateway = $request->input('gateway');
                \ShoppingCart::setAttribute('checkoutToken', $checkoutToken);
                \ShoppingCart::setAttribute('gateway', $gateway);
            } else if ($step == "shipping-method") {
                $shipping_method = $request->input('selected_shipping_method');
                \ShoppingCart::setAttribute('selected_shipping_method', $shipping_method);
            }
            echo json_encode(['action' => 'nextCheckoutStep', 'lastSuccessStep' => '#' . $step]);
        } catch (\Exception $exception) {
            log_exception($exception, 'CheckOutController', 'saveCheckoutStep', null, true);
        }
    }

    /**
     * @param $gateway
     * @param Order $order
     * @return $this
     */
    public function gatewayPayment($gateway_name, Order $order)
    {
        try {
            $ecommerce = new Ecommerce($gateway_name);
            $gateway = $ecommerce->gateway;

            //Add Additional Charges of exists from settings

            $additional_charge_amount = \Settings::get('ecommerce_additonalcharge_additonal_charge_amount', 0);
            $additional_charge_type = \Settings::get('ecommerce_additonalcharge_additonal_charge_type', '');
            $order->items()->where('sku_code', 'ADD_CHARGE')->delete();
            if ($additional_charge_amount && $additional_charge_type) {
                $additional_charge_title = \Settings::get('ecommerce_additonalcharge_additonal_charge_title', '');
                \ShoppingCart::removeFee($additional_charge_title);

                $apply_additional_charge = true;
                $additional_charge_gateways = \Settings::get('ecommerce_additonalcharge_additonal_charge_gateways', '');
                if ($additional_charge_gateways) {
                    $apply_charge_gateways = explode(',', $additional_charge_gateways);
                    if (!in_array($gateway_name, $apply_charge_gateways)) {
                        $apply_additional_charge = false;
                    }
                }
                if ($apply_additional_charge) {
                    if ($additional_charge_type == "fixed") {
                        $charge_amount = $additional_charge_amount;
                    } elseif ($additional_charge_type == "percentage") {
                        $charge_amount = ($additional_charge_amount / 100) * \ShoppingCart::subTotal(false);

                    }
                    if ($charge_amount) {
                        \ShoppingCart::addFee($additional_charge_title, $charge_amount);
                        $order->items()->create([
                            'amount' => $charge_amount,
                            'quantity' => 1,
                            'description' => $additional_charge_title,
                            'sku_code' => 'ADD_CHARGE',
                            'type' => 'Charge',
                        ]);
                    }
                }


            }
            //save amount again after additinal charge calculations
            $order->amount = \ShoppingCart::total(false);
            $order->save();

            $view = $gateway->getPaymentViewName('ecommerce');
            $action = 'e-commerce/checkout/step/select-payment';
            return view($view)->with(compact('gateway', 'action', 'order'));
        } catch (\Exception $exception) {
            log_exception($exception, 'CartController', 'card', null, true);
        }
    }

    /**
     * @param $gateway
     * @param Order $order
     * @param User $user
     * @return mixed
     */
    public function gatewayPaymentToken($gateway, Order $order, User $user)
    {
        if (is_null($user)) {
            $user = user();
        }
        try {
            $ecommerce = new Ecommerce($gateway);
            $token = $ecommerce->createPaymentToken($order, $user);
            return $token;
        } catch (\Exception $exception) {
            log_exception($exception, 'CartController', 'generatePaymentToken');
        }
    }

    public function doCheckout(Request $request)
    {
        $this->canAccessCheckout();

        $checkoutToken = \ShoppingCart::getAttribute('checkoutToken');
        $gateway = \ShoppingCart::getAttribute('gateway');
        $shipping_method = \ShoppingCart::getAttribute('selected_shipping_method');
        $shipping_address = \ShoppingCart::getAttribute('shipping_address');

        $order_id = $request->get('order_id');
        $order = Order::find($order_id);
        $user = user();
        $cart = \ShoppingCart::getItems();

        if ((count($cart) > 0) && $checkoutToken) {
            try {
                $payment_gateway = Payment::create($gateway);
                $shipping = [];

                if ($payment_gateway->getConfig('offline_management')) {

                    $billing = $order->billing;
                    $billing['payment_reference'] = $checkoutToken;
                    $billing['payment_status'] = 'pending';
                    $order->update([
                        'status' => 'pending',
                        'billing' => $billing,
                    ]);
                    $shipping['status'] = 'pending';
                } else {
                    $this->payGatewayOrder($order, $user, ['token' => $checkoutToken, 'gateway' => $gateway]);
                    if ($shipping_method) {
                        $shipping = \Shipping::createShippingTransaction($shipping_method);
                    }

                }
                if ($shipping_method) {

                    $shipping_rates = \ShoppingCart::getAttribute('shipping_rates');
                    $selected_shipping = $shipping_rates[$shipping_method];

                    $shipping['shipping_address'] = $shipping_address;
                    $shipping['shipping_provider'] = \Shipping::getProviderName($shipping_method);
                    $shipping['selected_shipping'] = $selected_shipping;

                    $order->shipping = $shipping;
                    $order->save();

                    session()->forget('selected_shipping_method');
                    session()->forget('shipping_address');

                }

                \Actions::do_action('post_order_received', $order);

                event('notifications.e_commerce.order.received', ['user' => user(), 'order' => $order]);

                $ecommerce = new Ecommerce();
                $ecommerce->deductFromInventory($order);
                $ecommerce->addContentAccess($order, $user);
                \ShoppingCart::destroyCart();

                flash('Order has been successfully placed')->success();
                return redirectTo($this->urlPrefix . 'checkout/order-success');
            } catch (\Exception $exception) {
                log_exception($exception, 'CheckOutController', 'doCheckout');
            }
        }

        return redirectTo($this->urlPrefix . 'checkout');
    }

    /**
     * @param $order
     * @param User $user
     * @param $checkoutDetails
     * @throws \Exception
     */
    protected function payGatewayOrder($order, User $user, $checkoutDetails)
    {
        $this->canAccessCheckout();

        $this->payGatewayOrderSend($order, $user, $checkoutDetails);
    }

    /**
     * @param $order
     * @param User $user
     * @param $checkoutDetails
     * @throws \Exception
     */
    protected function payGatewayOrderSend($order, User $user, $checkoutDetails)
    {
        $Ecommerce = new Ecommerce($checkoutDetails['gateway']);

        $Ecommerce->payOrder($order, $user, $checkoutDetails);
    }

    public
    function calculateCartTax($address)
    {
        $cart_items = \ShoppingCart::getItems();

        foreach ($cart_items as $cart_item) {
            $itemHash = $cart_item->getHash();
            $taxes = \Payments::calculateTax($cart_item->id->product, $address);

            $tax_rate = 0;

            foreach ($taxes as $tax) {
                $tax_rate += $tax['rate'];
            }
            \ShoppingCart::updateItem($itemHash, 'tax', $tax_rate);
        }
    }
}
