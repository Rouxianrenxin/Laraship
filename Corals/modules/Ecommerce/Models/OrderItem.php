<?php

namespace Corals\Modules\Ecommerce\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderItem extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'ecommerce_order_items';
    /**
     *  Model configuration.
     * @var string
     */

    protected $casts = [
        'item_options' => 'array',
    ];

    public $config = 'ecommerce.models.order_item';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function sku()
    {
        return $this->belongsTo(SKU::class, 'sku_code', 'code');
    }
}
