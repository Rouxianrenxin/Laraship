<?php

namespace Corals\Modules\Subscriptions\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Payment\Payment;
use Corals\Modules\Subscriptions\Models\Subscription;

class SubscriptionRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Subscription::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Subscription::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'subscription_reference' => 'required|max:191',
                'status' => 'required',
                'plan_id' => 'required',
                'gateway' => 'required',
                'user_id' => 'required',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'subscription_reference' => 'required|max:191|unique:subscriptions,subscription_reference'
            ]);
        }

        if ($this->isUpdate()) {
            $subscription = $this->route('subscription');
            $rules = array_merge($rules, [
                'subscription_reference' => 'required|max:191|unique:subscriptions,subscription_reference,' . $subscription->id,
            ]);
        }

        $gateway_key = $this->input('gateway');
        $status = $this->input('status');
        if ($gateway_key && $status == "active") {

            if (\Payments::isGatewaySupported($gateway_key)) {
                $gateway = Payment::create($gateway_key);
                if ($gateway->getConfig('offline_management')) {
                    $rules = array_merge($rules, ['next_billing_at' => 'required',
                    ]);

                }
            }
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'next_billing_at.required' => trans('Subscriptions::labels.subscription_request.next_billing_date_field'),
        ];
    }

}
