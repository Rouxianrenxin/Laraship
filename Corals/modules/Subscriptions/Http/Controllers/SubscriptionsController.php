<?php

namespace Corals\Modules\Subscriptions\Http\Controllers;

use Corals\Foundation\DataTables\CoralsBuilder;
use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Payment\Payment;
use Corals\Modules\Subscriptions\Classes\Subscription;
use Corals\Modules\Subscriptions\DataTables\SubscriptionsDataTable;
use Corals\Modules\Subscriptions\Http\Requests\SubscriptionCheckoutRequest;
use Corals\Modules\Subscriptions\Http\Requests\SubscriptionRequest;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\User\Models\User;
use Illuminate\Http\Request;
use Corals\Modules\Subscriptions\Models\Subscription as SubscriptionModel;

class SubscriptionsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('subscriptions.models.subscription.resource_url');

        $this->title = 'Subscriptions::module.subscription.title';

        $this->title_singular = 'Subscriptions::module.subscription.title_singular';

        parent::__construct();
    }

    /**
     * @param Request $request
     * @param SubscriptionModel $subscription
     * @return $this
     */
    public function show(Request $request, SubscriptionModel $subscription)
    {
        $this->checkAccess();

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $subscription->hashed_id . '/edit']);

        CoralsBuilder::DataTableScripts();

        return view('Subscriptions::subscription.show')->with(compact('subscription'));
    }

    private function checkAccess()
    {
        if (!user()->hasPermissionTo('Subscriptions::subscriptions.view')) {
            abort(403);
        }
    }

    public function index(Request $request, SubscriptionsDataTable $dataTable)
    {
        $this->checkAccess();

        return $dataTable->render('Subscriptions::subscription.index');
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return $this
     */
    public function pricing(Request $request, Product $product)
    {
        $this->setViewSharedData([
            'title' => trans('Subscriptions::module.plan.title'),
            'hide_sidebar' => true
        ]);

        $products = Product::active();

        if ($product->exists) {
            $products = $products->where('id', $product->id);
        }

        $products = $products->get();

        return view('Subscriptions::subscription.pricing')->with(compact('products'));
    }

    public function confirmationPage($message, $continueUrl = null)
    {
        $this->setViewSharedData([
            'title' => trans('Subscriptions::module.confirmation.title'),
            'hide_sidebar' => true
        ]);

        return view('Subscriptions::subscription.confirmation')->with(compact('message', 'continueUrl'));
    }

    public function statusPage(Request $request)
    {
        $this->setViewSharedData([
            'title' => trans('Corals::attributes.status'),
            'hide_sidebar' => true
        ]);

        $message = $request->get('message', false);

        if (!$message) {
            abort(404);
        }

        return view('Subscriptions::subscription.status')->with(compact('message'));
    }


    /**
     * @param Plan $plan
     * @param Subscription|null $subscription
     * @param User|null $user
     * @return bool|null
     * @throws \Exception
     */
    public function subscribe(Plan $plan, Subscription $subscription = null, User $user = null, $subscription_data)
    {
        if (is_null($user)) {
            $user = user();
        }

        $user_subscription = null;

        if ($user->subscribed(null, $plan->id)) {
            //already subscribed on the requested plan
            throw new \Exception(trans('Subscriptions::exception.subscription.already_subscribe', ['name' => $plan->name]));
        } elseif ($user->subscribed($plan->product_id)) {

            $userProductSubscription = $user->currentSubscription($plan->product_id);

            if (!\Payments::isGatewaySupported($userProductSubscription->gateway)) {
                /**
                 * new subscription on new product
                 * in case current product plan is free;
                 **/
                $user_subscription = $subscription->createSubscription($plan);
                $userProductSubscription->markAsCancelled();

            } else {
                $current_product_subscription = new Subscription($userProductSubscription->gateway);

                if ($plan->free_plan) {
                    /**
                     * Swap to free plan
                     * cancel subscription in case the new plan is free plan
                     */
                    $current_product_subscription->cancelSubscription($userProductSubscription->plan);
                    //subscribe to free plan
                    $user_subscription = $user->subscriptions()->create([
                        'plan_id' => $plan->id,
                        'gateway' => 'Free',
                        'subscription_reference' => 'free_' . str_random(6),
                    ]);
                } else {

                    //cancel current subscription if different gateway
                    if ($current_product_subscription->gateway->getName() != $subscription->gateway->getName()) {
                        $current_product_subscription->cancelSubscription($userProductSubscription->plan);
                        $user_subscription = $subscription->createSubscription($plan, $subscription_data);
                    } else {
                        // swap to another plan on same product
                        $user_subscription = $subscription->swapSubscription($plan);
                    }

                    // no invoice items generated on trial period
                    if (!$userProductSubscription->onTrial() && $subscription->gateway->getConfig('require_invoice_creation')) {
                        $invoiceReference = $subscription->createInvoice($user, $plan);
                        if ($invoiceReference) {
                            $subscription->payInvoice($invoiceReference);
                        }
                    }
                }
            }
        } else {
            // new subscription on new product
            if ($plan->free_plan) {
                $user_subscription = $user->subscriptions()->create([
                    'plan_id' => $plan->id,
                    'gateway' => 'Free',
                    'subscription_reference' => 'free_' . str_random(6),
                ]);

            } else {
                $user_subscription = $subscription->createSubscription($plan);

            }
        }

        return $user_subscription;
    }

    /**
     * @param Request $request
     * @param Plan $plan
     * @param User|null $user
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cancel(Request $request, Plan $plan, User $user = null)
    {
        $confirmed = $request->get('confirmed', false);

        if (!$confirmed) {
            $message = trans('Subscriptions::exception.subscription.cancel_subscribe_plan', ['name' => $plan->name]);
            return $this->confirmationPage($message);
        }


        if (is_null($user)) {
            $user = user();
        }
        $current_subscription = $user->currentSubscription(null, $plan->id);

        try {

            if (!$user->subscribed(null, $plan->id)) {
                throw new \Exception(trans('Subscriptions::exception.subscription.invalid_cancellation_request'));
            } else {
                if (!\Payments::isGatewaySupported($current_subscription->gateway)) {
                    // cancel subscription
                    $current_subscription->markAsCancelled();
                } else {
                    $subscription = new Subscription($current_subscription->gateway);
                    $subscription->cancelSubscription($plan);
                }


            }
            //status page
            $message = trans('Subscriptions::labels.subscription.subscription_name_success', ['name' => $plan->name]);

            if (!$plan->free_plan) {
                $message .= trans('Subscriptions::labels.subscription.access_account_till_end');
            }

            return redirect('subscriptions/status?message=' . urlencode($message));
        } catch (\Exception $exception) {
            log_exception($exception, 'SubscriptionsController', 'cancel');
        }

        return redirect('dashboard');
    }

    /**
     * @param Request $request
     * @param Plan $plan
     * @param User|null $user
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkout(Request $request, Plan $plan, User $user = null)
    {

        try {

            $gateway_name = null;
            $gateway = null;

            if (is_null($user)) {
                $user = user();
            }
            //Check if its Subscription Swap
            $current_plan = null;
            if ($plan) {
                if ($user->subscribed($plan->product_id)) {
                    $current_plan_subscription = $user->currentSubscription($plan->product_id);
                    if (\Payments::isGatewaySupported($current_plan_subscription->gateway)) {
                        $gateway_name = $current_plan_subscription->gateway;
                    }
                    $current_plan = $current_plan_subscription->plan;
                }

            }
            if (!$gateway_name) {
                $available_gateways = \Payments::getAvailableGateways();
                if (count($available_gateways) == 1) {
                    $gateway_name = key($available_gateways);
                }
            }

            /**
             * check if user gateway null
             * or
             * if user gateway not in supported gateways in case of supported gateways changed
             */

            $this->setViewSharedData([
                    'title' => trans('Subscriptions::module.checkout_details.title'),
                    'hide_sidebar' => true]
            );

            if ($gateway_name) {
                $subscription = new Subscription($gateway_name);
                $gateway = $subscription->gateway;
            }

            $billing_address = [];
            $shipping_address = [];
            $enable_shipping = $plan->product->require_shipping_address;

            if (!$billing_address) {
                if (user()->address('billing')) {
                    $billing_address = user()->address('billing');
                }
            }


            if (user()->address('shipping')) {
                $shipping_address = user()->address('shipping');

            }

            \Assets::add(asset('assets/corals/plugins/smartwizard/css/smart_wizard.min.css'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/css/smart_wizard_theme_arrows.css'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/js/jquery.smartWizard.min.js'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/js/validator.min.js'));

            $require_payment_step = true;
            if ($gateway) {
                if (!$gateway->userRequirePayment($user)) {
                    $require_payment_step = false;
                }
            }
            if ($plan->free_plan) {
                $require_payment_step = false;
            }

            return view('Subscriptions::subscription.checkout')->with(compact('require_payment_step', 'enable_shipping', 'shipping_address', 'billing_address', 'plan', 'current_plan', 'gateway', 'user'));
        } catch (\Exception $exception) {
            log_exception($exception, 'SubscriptionController', 'checkout');
            return redirect('profile');
        }
    }

    /**
     * @param Request $request
     * @param User|null $user
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentConfiguration(Request $request, User $user = null)
    {
        if (is_null($user)) {
            $user = user();
        }
        try {

            $gateway_name = null;
            if (!is_null($user->gateway) && \Payments::isGatewaySupported($user->gateway)) {
                $gateway_name = $user->gateway;
            } else {
                throw new \Exception(trans('Subscriptions::exception.subscription.invalid_user_gateway'));
            }

            $this->setViewSharedData([
                'title' => trans('Subscriptions::module.payment_details.title'),
                'hide_sidebar' => true
            ]);

            $subscription = new Subscription($gateway_name);
            $gateway = $subscription->gateway;

            return view('Subscriptions::subscription.payment_config')->with(compact('gateway', 'user'));
        } catch (\Exception $exception) {
            log_exception($exception, 'SubscriptionController', 'payment-configuration');
            return redirect('profile');
        }
    }


    /**
     * @param $gateway
     * @param Plan $plan
     * @return $this
     */
    public function gatewayPayment($gateway, Plan $plan)
    {
        try {
            $subscription = new Subscription($gateway);
            $action = 'subscriptions/do-checkout/' . $plan->hashed_id;
            $gateway = $subscription->gateway;
            $view = $gateway->getPaymentViewName('subscription');
            return view($view)->with(compact('plan', 'gateway', 'action'));
        } catch (\Exception $exception) {
            log_exception($exception, 'SubscriptionController', 'card');
        }
    }


    /**
     * @param $gateway
     * @param Plan $plan
     * @return $this
     */
    public function gatewaySubscriptionToken($gateway, Plan $plan, User $user)
    {
        if (is_null($user)) {
            $user = user();
        }
        try {
            $subscription = new Subscription($gateway);
            $token = $subscription->createSubscriptionToken($plan, $user);
            return $token;
        } catch (\Exception $exception) {
            log_exception($exception, 'SubscriptionController', 'generateSubscriptionToken');
        }
    }

    /**
     * @param SubscriptionRequest $request
     * @param Plan $plan
     * @param User|null $user
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function doCheckout(SubscriptionCheckoutRequest $request, Plan $plan, User $user = null)
    {
        $gateway = $request->gateway;
        $subscription_data = $request->only('billing_address', 'shipping_address');
        $user_data = $request->only('card_last_four', 'card_brand');
        if (is_null($user)) {
            $user = user();
        }
        $subscription = null;
        try {
            if ($gateway) {
                $checkoutToken = $request->checkoutToken;

                session()->put('checkoutToken', $checkoutToken);


                // $user->gateway = $gateway;
                //$user->save();
                $subscription = new Subscription($gateway);

                if ($subscription->gateway->getConfig('create_remote_customer')) {
                    if (is_null($user->integration_id)) {
                        try {
                            $subscription->createCustomer($user, ['checkoutToken' => $checkoutToken, 'billing_address' => $request->billing_address, 'shipping_address' => $request->shipping_address]);

                        } catch (\Exception $exception) {
                            log_exception($exception, 'SubscriptionController', 'saveCard');
                            return redirectTo('subscriptions/checkout/' . $plan->hashed_id);
                        }
                    } else {
                        try {
                            $subscription->updateCustomer($user, ['checkoutToken' => $checkoutToken, 'billing_address' => $request->billing_address, 'shipping_address' => $request->shipping_address]);

                        } catch (\Exception $exception) {
                            log_exception($exception, 'SubscriptionController', 'saveCard');
                            return redirectTo('subscriptions/checkout/' . $plan->hashed_id);
                        }
                    }
                }
            }

            if ($plan->exists) {
                if ($gateway) {
                    $subscription = new Subscription($gateway);
                    if (!$subscription->isValidSubscription($plan, $user)) {
                        //Payment Details are missing
                        return redirect('subscriptions/checkout/' . $plan->hashed_id);
                    }
                }

                $user_subscription = $this->subscribe($plan, $subscription, $user, $subscription_data);
                $user_subscription->update($subscription_data);

                if ($user_data) {
                    //save address to user section
                    $user->update($user_data);
                }

                if ($request->input('save_billing')) {
                    $user->saveAddress($request->input('billing_address'), 'billing');
                }
                if ($request->input('save_shipping')) {
                    $user->saveAddress($request->input('shipping_address'), 'shipping');
                }

                //status page
                $subscription_message = $this->getSubscriptionCreationMessage($user_subscription);

                return redirectTo('subscriptions/status?message=' . urlencode($subscription_message));

            } else {
                flash(trans('Corals::messages.success.saved', ['item' => trans('Subscriptions::module.card.title')]))->success();
                return redirectTo('profile');
            }
        } catch (\Exception $exception) {
            log_exception($exception, 'SubscriptionsController', 'subscribe');
            return redirectTo('profile');
        }
    }


    private function getSubscriptionCreationMessage($user_subscription)
    {
        if ($user_subscription->status == "pending") {

            $message = trans('Subscriptions::labels.subscription.subscription_request_received');

        } else {
            $message = trans('Subscriptions::labels.subscription.you_have_subscribed_success', ['name' => $user_subscription->plan->name]);

        }

        $message = \Filters::do_filter('subscription_creation_message', $message, $user_subscription);
        return $message;
    }

    /**
     * @param Request $request
     * @param User|null $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function saveCard(Request $request, User $user = null)
    {
        $checkoutToken = $request->checkoutToken;
        $card_last_four = $request->card_last_four;
        $card_brand = $request->card_brand;
        $gateway = $request->gateway;
        session()->put('checkoutToken', $checkoutToken);

        if (is_null($user)) {
            $user = user();
        }

        $user->gateway = $gateway;

        $user->save();

        $subscription = new Subscription($gateway);

        if ($subscription->gateway->getConfig('create_remote_customer')) {
            if (is_null($user->integration_id)) {
                try {
                    $subscription->createCustomer($user, ['checkoutToken' => $checkoutToken, 'billing_address' => $user->address('billing'), 'shipping_address' => $user->address('shipping')]);
                } catch (\Exception $exception) {
                    log_exception($exception, 'SubscriptionController', 'saveCard');
                }
            } else {
                try {
                    $subscription->updateCustomer($user, ['checkoutToken' => $checkoutToken, 'billing_address' => $user->address('billing'), 'shipping_address' => $user->address('shipping')]);

                } catch (\Exception $exception) {
                    log_exception($exception, 'SubscriptionController', 'saveCard');
                }
            }
        }

        $user->update([
            'card_last_four' => $card_last_four,
            'card_brand' => $card_brand,
        ]);

        flash(trans('Corals::messages.success.saved', ['item' => trans('Subscriptions::module.payment_details.title_singular')]))->success();

        return redirect('profile');
    }

    /**
     * @param SubscriptionRequest $request
     * @param SubscriptionModel $subscription
     * @return $this
     */
    public function edit(SubscriptionRequest $request, SubscriptionModel $subscription)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $subscription->subscription_reference])]);

        $gateway = Payment::create($subscription->gateway);

        if ($gateway->getConfig('offline_management') && is_null($subscription->next_billing_at)) {
            $subscription->next_billing_at = $subscription->created_at->addDays($subscription->remainingDays());
        }

        return view('Subscriptions::subscription.create_edit')->with(compact('subscription'));
    }

    /**
     * @param SubscriptionModel $subscription
     * @return $this
     */
    public function create(SubscriptionModel $subscription)
    {
        return view('Subscriptions::subscription.create_edit')->with(compact('subscription'));
    }


    /**
     * @param SubscriptionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SubscriptionRequest $request)
    {
        try {
            $data = $request->all();
            $subscription = SubscriptionModel::create($data);
            if ($subscription->status == "canceled") {
                $subscription->markAsCancelled();
            } elseif ($subscription->status == "active") {
                $user = $subscription->user;
                event('notifications.subscription.created', ['user' => $user, 'subscription' => $subscription]);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, SubscriptionModel::class, 'create');
        }

        return redirectTo($this->resource_url . '/' . $subscription->hashed_id);
    }

    /**
     * @param SubscriptionRequest $request
     * @param SubscriptionModel $subscription
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SubscriptionRequest $request, SubscriptionModel $subscription)
    {
        try {
            $data = $request->all();
            $old_status = $subscription->status;
            $new_status = $data['status'];
            $subscription->update($data);
            if ($old_status != $new_status) {
                if ($new_status == "canceled") {
                    $subscription->markAsCancelled();
                } elseif ($new_status == "active" && $old_status == "pending") {
                    $user = $subscription->user;
                    event('notifications.subscription.approved', ['user' => $user, 'subscription' => $subscription]);

                }
            }
            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, SubscriptionModel::class, 'update');
        }
        return redirectTo($this->resource_url . '/' . $subscription->hashed_id);
    }

    /**
     * @param SubscriptionModel $subscription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createInvoice(SubscriptionModel $subscription)
    {
        $this->setViewSharedData(['title_singular' => trans('Subscriptions::labels.subscription.create_invoice', ['name' => $subscription->subscription_reference])]);

        $invoicable_resource_url = $this->resource_url;

        $this->setViewSharedData(['resource_url' => config('payment_common.models.invoice.resource_url')]);

        $invoicable = $subscription;

        $invoice = new Invoice();

        $invoice->due_date = now();

        return view('Payment::invoices.create_edit')->with(compact('invoice', 'invoicable', 'invoicable_resource_url'));
    }
}
