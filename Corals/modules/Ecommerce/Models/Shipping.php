<?php

namespace Corals\Modules\Ecommerce\Models;

use Carbon\Carbon;
use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;

class Shipping extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'ecommerce_shippings';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'ecommerce.models.shipping';

    protected static $logAttributes = ['status'];

    protected $guarded = ['id'];

    protected $casts = [
    ];

    protected $dates = [
        'start',
        'expiry'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'ecommerce_shipping_user');
    }

    public function status()
    {
        if ($this->start <= Carbon::today()->toDateString() && ($this->expiry >= Carbon::today()->toDateString())) {
            return "active";

        } else if ($this->start > Carbon::today()->toDateString()) {
            return "pending";

        } else {
            return "expired";
        }
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ecommerce_shipping_product');
    }
}
