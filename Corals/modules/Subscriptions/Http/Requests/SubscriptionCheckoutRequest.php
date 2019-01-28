<?php

namespace Corals\Modules\Subscriptions\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Payment\Payment;

use Corals\Modules\Subscriptions\Models\Subscription;

class SubscriptionCheckoutRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $plan = $this->route('plan');
        $this->setModel(Subscription::class);
        $rules = parent::rules();
        $gateway = $this->get('gateway');
        $require_payment_step = true;

        if ($gateway) {
            $payment_gateway =  Payment::create($gateway);
            if (!$payment_gateway->userRequirePayment(user())) {
                $require_payment_step = false;
            }
        }
        if ($plan->free_plan) {
            $require_payment_step = false;
        }
        if ($require_payment_step) {
            $rules = array_merge($rules, [
                'gateway' => 'required',
                'checkoutToken' => 'required',
            ]);
        }

        $enable_shipping = $plan->product->require_shipping_address;

        $rules = array_merge($rules, [
            'billing_address.address_1' => 'required',
            'billing_address.city' => 'required',
            'billing_address.state' => 'required',
            'billing_address.country' => 'required',
            'billing_address.zip' => 'required',
        ]);
        if ($enable_shipping) {
            $rules = array_merge($rules, [
                'shipping_address.address_1' => 'required',
                'shipping_address.city' => 'required',
                'shipping_address.state' => 'required',
                'shipping_address.country' => 'required',
                'shipping_address.zip' => 'required',
            ]);
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'checkoutToken.required' => trans('Subscriptions::labels.subscription.payment_are_missing'),
        ];
    }

}
