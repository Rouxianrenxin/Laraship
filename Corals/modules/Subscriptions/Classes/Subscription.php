<?php

namespace Corals\Modules\Subscriptions\Classes;


use Carbon\Carbon;
use Corals\Modules\Payment\Payment;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\User\Models\User;

class Subscription
{
    public $gateway;

    /**
     * Subscriptions constructor.
     * @param $gateway_key
     * @param array $params
     * @throws \Exception
     */
    function __construct($gateway_key, array $params = [])
    {

        $gateway = Payment::create($gateway_key);
        $config = config('payment_' . strtolower($gateway_key));
        if (!$config) {
            throw new \Exception(trans('Subscriptions::exception.subscription.invalid_gateway'));
        }

        $this->gateway = $gateway;

        $this->gateway->setAuthentication();

        foreach ($params as $key => $value) {
            $this->gateway->setParameter($key, $value);
        }
    }

    /**
     * @param User $user
     * @param array $extra_params
     * @return bool
     * @throws \Exception
     */
    public function createCustomer(User $user, $extra_params = [])
    {
        $parameters = $this->gateway->prepareCustomerParameters($user, $extra_params);

        \Actions::do_action('pre_create_customer', $this, $user, $parameters);

        $parameters = \Filters::do_filter('create_customer_parameters', $parameters, $user, $this->gateway);

        $request = $this->gateway->createCustomer($parameters);

        // check if gateway support create/update customer request
        if ($request) {
            $response = $request->send();
            if ($response->isSuccessful()) {
                //"Gateway createCustomer was successful.\n";
                // Find the customer ID and update user if not null
                $customer_id = $response->getCustomerReference();
                $payment_method_token = "";
                if ($this->gateway->getConfig('capture_payment_method')) {
                    $payment_method_token = $response->getPaymentMethodReference();
                }
                $user->update(['integration_id' => $customer_id, 'payment_method_token' => $payment_method_token, 'gateway' => $this->gateway->getName()]);

                \Actions::do_action('post_create_customer', $this, $user, $response);

                return $customer_id;
            } else {
                throw new \Exception(trans('Subscriptions::exception.subscription.create_customer_failed', ['message' => $response->getMessage()]));
            }
        } else {
            return true;
        }
    }

    /**
     * @param User $user
     * @param array $extra_params
     * @return bool
     * @throws \Exception
     */
    public function updateCustomer(User $user, $extra_params = [])
    {
        $parameters = $this->gateway->prepareCustomerParameters($user, $extra_params);

        \Actions::do_action('pre_update_customer', $this, $user, $parameters);

        $parameters = \Filters::do_filter('update_customer_parameters', $parameters, $user, $this->gateway);


        $request = $this->gateway->updateCustomer($parameters);

        // check if gateway support create/update customer request
        if ($request) {
            $response = $request->send();

            if ($response->isSuccessful()) {
                //"Gateway updateCustomer was successful.\n";
                // Find the customer ID and update user if not null
                $customer_id = $response->getCustomerReference();
                $payment_method_token = '';
                if ($this->gateway->getConfig('capture_payment_method')) {
                    $payment_method_token = $response->getPaymentMethodReference();
                }
                $user->update(['integration_id' => $customer_id, 'payment_method_token' => $payment_method_token, 'gateway' => $this->gateway->getName()]);

                if ($this->gateway->getConfig('require_default_payment_set')) {
                    $parameters = $this->gateway->prepareCustomerParameters($user);
                    $request = $this->gateway->updateCustomer($parameters);

                    $this->gateway->updateCustomer($parameters);
                    $response = $request->send();
                    if (!$response->isSuccessful()) {
                        throw new \Exception(trans('Subscriptions::exception.subscription.payment_set_failed', ['message' => $response->getMessage()]));

                    }
                }

                \Actions::do_action('post_update_customer', $this, $response, $user);

                return $customer_id;
            } else {
                throw new \Exception(trans('Subscriptions::exception.subscription.update_customer_failed', ['message' => $response->getMessage()]));
            }
        } else {
            return true;
        }
    }

    /**
     * @return mixed
     */
    public function fetchCustomer()
    {

    }

    /**
     * @param User $user
     * @param array $extra_params
     * @return bool
     * @throws \Exception
     */
    public function deleteCustomer(User $user, $extra_params = [])
    {
        $parameters = $this->gateway->prepareCustomerParameters($user, $extra_params = []);

        \Actions::do_action('pre_delete_customer', $this, $user, $parameters);

        $parameters = \Filters::do_filter('delete_customer_parameters', $parameters, $user, $this->gateway);

        $request = $this->gateway->deleteCustomer(array_merge($parameters, $extra_params));
        // check if gateway support create/update/delete customer request
        if ($request) {
            $response = $request->send();

            if ($response->isSuccessful()) {
                //"Gateway deleteCustomer was successful.\n";
                // Find the customer ID and update user if not null
                \Actions::do_action('post_delete_customer', $this, $response, $user);

                return true;
            } else {
                throw new \Exception(trans('Subscriptions::exception.subscription.delete_customer_failed', ['message' => $response->getMessage()]));
            }
        } else {
            return true;
        }
    }

    /**
     * @param Plan $plan
     * @param User|null $user
     * @return bool
     * @throws \Exception
     */
    public function createSubscription(Plan $plan, User $user = null, $subscription_data = null)
    {
        if (is_null($user)) {
            $user = user();
        }

        $trial_ends_at = null;
        $subscription = null;


        $parameters = $this->gateway->prepareSubscriptionParameters($plan, $user, null, $subscription_data);

        \Actions::do_action('pre_create_subscription', $this, $user, $parameters, $plan);

        $parameters = \Filters::do_filter('create_subscription_parameters', $parameters, $user, $plan, $this->gateway);

        $request = $this->gateway->createSubscription($parameters);
        $response = $request->send();
        if ($response->isSuccessful()) {
            // Subscription was created successful
            if (!empty($plan->trial_period)) {
                $trial_ends_at = Carbon::now()->addDays($plan->trial_period);
            }
            $subscriber_data = [
                'plan_id' => $plan->id,
                'gateway' => $this->gateway->getName(),
                'subscription_reference' => $response->getSubscriptionReference(),
                'trial_ends_at' => $trial_ends_at,
            ];

            if ($this->gateway->getConfig('default_subscription_status')) {
                $subscriber_data['status'] = $this->gateway->getConfig('default_subscription_status');
            }
            $subscription = $user->subscriptions()->create($subscriber_data);

            $user->update([
                'trial_ends_at' => $trial_ends_at
            ]);

            event('notifications.subscription.created', ['user' => $user, 'subscription' => $subscription]);
            \Actions::do_action('post_create_subscription', $subscription);

        } else {
            throw new \Exception(trans('Subscriptions::exception.subscription.create_subscription_failed', ['message' => $response->getMessage()]));
        }


        return $subscription;
    }

    /**
     * @return mixed
     */
    public function fetchSubscription()
    {
    }

    /**
     * @param Plan $plan
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function createSubscriptionToken(Plan $plan, User $user)
    {
        $parameters = $this->gateway->prepareSubscriptionTokenParameters($plan, $user);

        $request = $this->gateway->prepareSubscription($parameters);

        $response = $request->send();


        if ($response->isSuccessful()) {
            $token = $response->getSubscriptionTokenReference();
            return $token;
        } else {
            throw new \Exception(trans('Subscriptions::exception.subscription.create_subscription_token_failed', ['message' => $response->getDataText()]));
        }
    }


    /**
     * @param Plan $plan
     * @param User|null $user
     * @return bool
     * @throws \Exception
     */
    public function swapSubscription(Plan $plan, User $user = null)
    {
        if (is_null($user)) {
            $user = user();
        }

        $product_subscription = $user->currentSubscription($plan->product_id);

        if (!$product_subscription) {
            throw new \Exception(trans('Subscriptions::exception.subscription.invalid_subscription'));
        }

        \Actions::do_action('pre_swap_subscription', $user, $plan);


        $trial_ends_at = $product_subscription->trial_ends_at;

        if ($product_subscription->onGracePeriod() && !$this->gateway->getConfig('supports_swap_in_grace_period')) {

            $product_subscription->markAsCancelled();

            $subscription = $this->createSubscription($plan, $user);
        } else {
            $parameters = $this->gateway->prepareSubscriptionParameters($plan, $user, $product_subscription);

            $parameters = \Filters::do_filter('swap_subscription_parameters', $parameters, $user, $plan, $product_subscription, $this->gateway);

            if ($this->gateway->getConfig('supports_swap')) {
                $request = $this->gateway->updateSubscription($parameters);
            } else {

                $this->cancelSubscription($product_subscription->plan, $user);
                $request = $this->gateway->createSubscription($parameters);
            }


            $response = $request->send();

            if ($response->isSuccessful()) {

                $product_subscription->markAsCancelled();

                $subscriber_data = [
                    'plan_id' => $plan->id,
                    'subscription_reference' => $response->getSubscriptionReference(),
                    'trial_ends_at' => $trial_ends_at,
                    'gateway' => $this->gateway->getName(),
                ];

                if ($this->gateway->getConfig('default_subscription_status')) {
                    $subscriber_data['status'] = $this->gateway->getConfig('default_subscription_status');
                }

                $subscription = $user->subscriptions()->create($subscriber_data);

                event('notifications.subscription.swapped', ['user' => $user, 'subscription' => $subscription, 'old_subscription' => $product_subscription]);
            } else {
                throw new \Exception(trans('Subscriptions::exception.subscription.update_subscription_failed', ['message' => $response->getMessage()]));
            }
        }

        \Actions::do_action('post_swap_subscription', $user, $plan, $subscription);

        return $subscription;
    }

    /**
     * @param Plan $plan
     * @param User|null $user
     * @return bool
     * @throws \Exception
     */
    public function cancelSubscription(Plan $plan, User $user = null)
    {
        if (is_null($user)) {
            $user = user();
        }

        $plan_subscription = $user->currentSubscription(null, $plan->id);

        if (!$plan_subscription) {
            throw new \Exception(trans('Subscriptions::exception.subscription.invalid_subscription'));
        }

        \Actions::do_action('pre_cancel_subscription', $user, $plan);


        $parameters = $this->gateway->prepareSubscriptionCancellationParameters($user, $plan_subscription);

        $parameters = \Filters::do_filter('cancel_subscription_parameters', $parameters, $user, $plan_subscription, $this->gateway);

        $request = $this->gateway->cancelSubscription($parameters);

        $response = $request->send();
        if ($response->isSuccessful()) {
            if ($plan_subscription->onTrial()) {
                $ends_at = $plan_subscription->trial_ends_at;
            } else {
                $data = $response->getData();
                $current_period_end = $response->getCurrentPeriodEndReference();
                $ends_at = Carbon::createFromTimestamp($current_period_end);
            }

            $plan_subscription->update([
                'ends_at' => $ends_at,
                'status' => 'canceled'
            ]);

            event('notifications.subscription.cancelled', ['user' => $user, 'subscription' => $plan_subscription]);

            \Actions::do_action('post_cancel_subscription', $plan_subscription);
            return true;
        } else {
            throw new \Exception(trans('Subscriptions::exception.subscription.cancel_subscription_failed', ['message' => $response->getMessage()]));
        }
    }

    /**
     * @param Plan $plan
     * @return mixed
     * @throws \Exception
     */
    public function createPlan(Plan $plan)
    {
        \Actions::do_action('pre_create_plan', $plan, $this->gateway);

        $parameters = $this->gateway->preparePlanParameters($plan);

        $parameters = \Filters::do_filter('create_plan_parameters', $parameters, $plan, $this->gateway);


        $request = $this->gateway->createPlan($parameters);

        $response = $request->send();

        if ($response->isSuccessful()) {
            // Plan was created successful
            $planId = $response->getPlanId();
            $plan->setGatewayStatus($this->gateway->getName(), 'CREATED', null, $planId);

            if ($this->gateway->getConfig('require_plan_activation')) {
                $parameters = $this->gateway->preparePlanActivationParameters($plan);
                $request = $this->gateway->activatePlan($parameters);
                $response = $request->send();
            }

            \Actions::do_action('post_create_plan', $plan, $this->gateway);

            if (!$response->isSuccessful()) {
                $message = trans('Subscriptions::exception.subscription.update_gateway_status_failed', ['message' => $response->getMessage()]);
                throw new \Exception($message);
            }

        } else {
            // Create Plan failed
            $message = trans('Subscriptions::exception.subscription.create_gateway_fail', ['message' => $response->getMessage()]);

            $plan->setGatewayStatus($this->gateway->getName(), 'CREATE_FAILED', $message);

            throw new \Exception($message);
        }
    }

    /**
     * @param Plan $plan
     * @return mixed
     * @throws \Exception
     */
    public function updatePlan(Plan $plan)
    {
        \Actions::do_action('pre_update_plan', $plan, $this->gateway);

        $parameters = $this->gateway->preparePlanParameters($plan);
        $parameters = \Filters::do_filter('update_plan_parameters', $parameters, $plan, $this->gateway);

        $request = $this->gateway->updatePlan($parameters);

        $response = $request->send();

        if ($response->isSuccessful()) {
            // Plan was created successful
            $plan->setGatewayStatus($this->gateway->getName(), 'UPDATED');

            \Actions::do_action('post_update_plan', $plan, $this->gateway);

            return $response->getPlanId();
        } else {
            // Create Plan failed
            $message = trans('Subscriptions::exception.subscription.update_gateway_plan_failed', ['message' => $response->getMessage()]);

            $plan->setGatewayStatus($this->gateway->getName(), 'UPDATE_FAILED', $message);

            throw new \Exception($message);
        }
    }

    /**
     * @param Plan $plan
     * @param $gateway
     * @return bool
     */
    public function fetchPlan(Plan $plan, $gateway)
    {
        \Actions::do_action('pre_fetch_plan', $plan, $this->gateway);

        $parameters = $this->gateway->preparePlanParameters($plan);
        $parameters = \Filters::do_filter('fetch_plan_parameters', $parameters, $plan, $this->gateway);

        $request = $this->gateway->fetchPlan($parameters);

        $response = $request->send();

        if ($response->isSuccessful()) {
            // Plan was created successful
            $data = $response->getData();
            $data = \Filters::do_filter('fetch_plan_response', $data, $plan, $this->gateway);

            \Actions::do_action('post_fetch_plan', $plan, $this->gateway);

            return $data;
        } else {
            // Fetch Plan failed
            $message = trans('Subscriptions::exception.subscription.fetch_gateway_plan_failed', ['message' => $response->getMessage()]);

            log_exception(null, 'requested plan: ' . $plan->name, 'fetchPlan', $message);

            session()->forget('flash_notification');

            return false;
        }
    }

    /**
     * @param $plan
     * @param $gateway
     * @return bool
     */
    public function deletePlan($plan, $gateway)
    {
        $parameters = $this->gateway->preparePlanParameters($plan);

        \Actions::do_action('pre_delete_plan', $plan, $this->gateway);

        $parameters = \Filters::do_filter('delete_plan_parameters', $parameters, $plan, $this->gateway);

        $request = $this->gateway->deletePlan($parameters);

        $response = $request->send();

        if ($response->isSuccessful()) {
            // Plan was created successful
            $plan->setGatewayStatus($this->gateway->getName(), 'DELETED');

            \Actions::do_action('post_delete_plan', $plan, $this->gateway);

            return $response->getData();
        } else {
            // Create Plan failed
            $message = trans('Subscriptions::exception.subscription.delete_gateway_failed', ['message' => $response->getMessage()]);

            $plan->setGatewayStatus($this->gateway->getName(), 'DELETE_FAILED', $message);

            log_exception(null, 'requested plan: ' . $plan->name, 'deletePlan', $message);

            return false;
        }
    }

    /**
     * @param User|null $user
     * @param Plan $plan
     * @return mixed
     * @throws \Exception
     */
    public function createInvoice(User $user = null, Plan $plan)
    {
        if (is_null($user)) {
            $user = user();
        }

        \Actions::do_action('pre_create_invoice', $plan, $user, $this->gateway);

        $attributes = $this->gateway->prepareInvoiceParameters($user, $plan);
        $attributes = \Filters::do_filter('create_invoice_parameters', $attributes, $plan, $user, $this->gateway);

        $request = $this->gateway->createInvoice($attributes);

        $response = $request->send();

        if ($response->isSuccessful()) {

            \Actions::do_action('post_create_invoice', $plan, $user, $this->gateway);
            return $response->getInvoiceReference();
        } else {
            // Create Invoice failed
            $message = trans('Subscriptions::exception.subscription.create_invoice_failed', ['arg' => $user->integration_id, 'message' => $response->getMessage()]);
            return false;
            //throw new \Exception($message);
        }
    }

    /**
     * @return mixed
     */
    public function fetchInvoice()
    {
    }

    /**
     * @return mixed
     */
    public function listInvoices()
    {
    }

    /**
     * @param $invoiceReference
     * @return bool
     * @throws \Exception
     */
    public function payInvoice($invoiceReference)
    {
        \Actions::do_action('pre_pay_invoice', $invoiceReference, $this->gateway);

        $parameters = ['invoiceReference' => $invoiceReference];
        $parameters = \Filters::do_filter('pay_invoice_parameters', $parameters, $this->gateway);

        $request = $this->gateway->payInvoice($parameters);

        $response = $request->send();

        if ($response->isSuccessful()) {

            \Actions::do_action('post_pay_invoice', $invoiceReference, $this->gateway);
            return true;
        } else {
            // Pay Invoice failed
            $message = trans('Subscriptions::exception.subscription.pay_invoice_failed', ['arg' => $invoiceReference, 'message' => $response->getMessage()]);

            throw new \Exception($message);
        }
    }

    /**
     * @param Plan $plan
     * @param User $user
     * @return boolean
     */
    public function isValidSubscription(Plan $plan, User $user = null)
    {
        \Actions::do_action('pre_subscription_check', $this, $plan, $user);

        if ($plan->free_plan) {
            return true;
        }

        if ($this->gateway->getConfig('create_remote_customer') && (is_null($user->integration_id))) {
            return false;
        }

        if ($this->gateway->getConfig('require_payment_token') && (!session()->get('checkoutToken'))) {
            return false;
        }

        return true;
    }
}