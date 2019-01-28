<?php

namespace Corals\Modules\Payment\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'payment_transactions';

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'payment_common.models.transaction';

    protected static $logAttributes = ['reference_id', 'amount', 'type', 'transaction_date'];

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get all of the owning invoicable models.
     */
    public function sourcable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the owning invoicable models.
     */
    public function owner()
    {
        return $this->morphTo();
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
