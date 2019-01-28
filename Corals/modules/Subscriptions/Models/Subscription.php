<?php

namespace Corals\Modules\Subscriptions\Models;

use Carbon\Carbon;
use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Payment\Models\Invoice;
use Corals\User\Models\User;

class Subscription extends BaseModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    use PresentableTrait;


    protected $guarded = [];

    public $config = 'subscriptions.models.subscription';


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at', 'ends_at', 'next_billing_at'
    ];

    protected $casts = [
        'extras' => 'array',
        'shipping_address' => 'array',
        'billing_address' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Determine if the subscription is active, on trial, or within its grace period.
     *
     * @return bool
     */
    public function valid()
    {
        return ($this->pending() || $this->active());
    }

    /**
     * Determine if the subscription is active.
     *
     * @return bool
     */
    public function active()
    {
        return (is_null($this->ends_at) || $this->onGracePeriod()) && (is_null($this->status) || $this->status == "active");
    }

    /**
     * Determine if the subscription is pending.
     *
     * @return bool
     */
    public function pending()
    {
        return $this->status == "pending";
    }


    /**
     * Determine if the subscription is no longer active.
     *
     * @return bool
     */
    public function cancelled()
    {
        return !is_null($this->ends_at);
    }

    /**
     * Mark the subscription as cancelled.
     *
     * @return void
     */
    public function markAsCancelled()
    {
        try {

            $end_date = Carbon::now();
            $end_date = \Filters::do_filter('subscription_cancellation_end_date', $end_date, $this);

            \Actions::do_action('pre_subscription_marked_as_cancelled', $this);
            $this->fill(['ends_at' => $end_date, 'status' => 'canceled'])->save();
        } catch (\Exception $exception) {
            flash("Error Cancelling ")->warning();
            log_exception($exception, 'SubscriptionController', 'cancel');
        }

    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->fill(['status' => $status])->save();
    }

    /**
     * Determine if the subscription is within its trial period.
     *
     * @return bool
     */
    public function onTrial()
    {
        if (!is_null($this->trial_ends_at)) {
            return Carbon::today()->lt($this->trial_ends_at);
        } else {
            return false;
        }
    }

    /**
     * Determine if the subscription is within its grace period after cancellation.
     *
     * @return bool
     */
    public function onGracePeriod()
    {
        if (!is_null($endsAt = $this->ends_at)) {
            return Carbon::now()->lt(Carbon::instance($endsAt));
        } else {
            return false;
        }
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoicable');
    }

    public function getInvoiceReference($target = "dashboard")
    {
        $plan = $this->plan;
        $product = $this->plan->product;
        if ($target == "pdf") {
            return "{$product->name} -  {$plan->name}";
        } else {
            return "<a href='" . url('subscriptions/products/' . $product->hashed_id) . "'> {$product->name} -  {$plan->name}</a>";

        }


    }

    public function remainingDays()
    {
        $now = Carbon::now();

        $stated_at = $this->created_at;

        $next_billing_at = $this->next_billing_at;

        $ends_at = $this->ends_at;

        $plan_cycle = $this->plan->bill_cycle;

        $plan_freq = $this->plan->bill_frequency;

        $remainingDays = 0;

        if ($ends_at) {
            $total_subscriptions_days = $ends_at->diffInDays($stated_at);

            $passed_subscription_days = $now->diffInDays($stated_at);

            $remainingDays = $total_subscriptions_days - $passed_subscription_days;
        } elseif ($next_billing_at) {
            $remainingDays = $next_billing_at->diffInDays();
        } else {
            $next_cycle_date = null;

            switch ($plan_cycle) {
                case 'week':
                    $next_cycle_date = $stated_at->addWeeks($plan_freq);

                    while ($now->gt($next_cycle_date)) {
                        $next_cycle_date = $stated_at->addWeeks($plan_freq);
                    }
                    break;
                case 'month':
                    $next_cycle_date = $stated_at->addMonths($plan_freq);

                    while ($now->gt($next_cycle_date)) {
                        $next_cycle_date = $stated_at->addMonths($plan_freq);
                    }
                    break;
                case 'year':
                    $next_cycle_date = $stated_at->addYears($plan_freq);

                    while ($now->gt($next_cycle_date)) {
                        $next_cycle_date = $stated_at->addYears($plan_freq);
                    }
                    break;
            }
            if ($next_cycle_date) {
                $remainingDays = $next_cycle_date->diffInDays();
            }
        }

        return $remainingDays;
    }

}