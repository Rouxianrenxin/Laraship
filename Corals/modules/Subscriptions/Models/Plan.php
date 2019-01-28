<?php

namespace Corals\Modules\Subscriptions\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Payment\Traits\GatewayStatusTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Plan extends BaseModel
{
    use PresentableTrait, LogsActivity, GatewayStatusTrait;

    protected $casts = [
        'free_plan' => 'boolean',
        'is_visible' => 'boolean',
        'extras' => 'array'
    ];

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'subscriptions.models.plan';

    protected static $logAttributes = [
        'name', 'description', 'price', 'discount', 'recommended', 'trial_period', 'free_plan', 'display_order', 'status'
    ];

    protected $guarded = ['id'];

    protected $appends = ['currency'];

    public function getCurrencyAttribute()
    {
        $currency = \Payments::admin_currency_code();

        return $currency;
    }

    public function getCurrencyIconAttribute()
    {
        $currency = $this->currency;

        return 'fa fa-fw fa-' . strtolower($currency);
    }

    public function getCycleCaptionAttribute()
    {
        $caption = '';

        if ($this->attributes['bill_frequency'] > 1) {
            $caption = 'Every ' . $this->attributes['bill_frequency'] . ' ' . ucfirst(str_plural($this->attributes['bill_cycle'], $this->attributes['bill_frequency']));
        } else {
            switch ($this->attributes['bill_cycle']) {
                case 'week':
                    $caption = 'Weekly';
                    break;
                case 'month':
                    $caption = 'Monthly';
                    break;
                case 'year':
                    $caption = 'Yearly';
                    break;
            }
        }

        return $caption;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class)->withPivot('value');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
