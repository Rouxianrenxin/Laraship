<?php

namespace Corals\Modules\Payment\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'payment_common.models.invoice';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    protected $casts = [
        'extras' => 'array'
    ];

    public function scopeMyInvoices($query)
    {
        return $query->where('user_id', user()->id);
    }

    public function markAsPaid()
    {
        $this->fill(['status' => 'paid'])->save();
    }

    public function markAsFailed()
    {
        $this->fill(['status' => 'failed'])->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning invoicable models.
     */
    public function invoicable()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
