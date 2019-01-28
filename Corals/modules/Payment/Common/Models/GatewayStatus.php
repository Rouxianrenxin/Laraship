<?php

namespace Corals\Modules\Payment\Models;

use Corals\Foundation\Models\BaseModel;
use Spatie\Activitylog\Traits\LogsActivity;

class GatewayStatus extends BaseModel

{
    use LogsActivity;

    protected static $logAttributes = ['gateway', 'status', 'message'];

    protected $guarded = ['id'];

    protected $table = 'gateway_status';

    public function ObjectType()
    {
        return $this->morphTo();
    }

    /**
     * @param $status
     * @param null $message
     */
    public function markAs($status, $message = null)
    {
        $this->fill(['status' => $status, 'message' => $message])->save();
    }
}
