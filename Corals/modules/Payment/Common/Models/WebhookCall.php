<?php

namespace Corals\Modules\Payment\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Facades\Webhooks;
use Exception;
use Spatie\Activitylog\Traits\LogsActivity;

class WebhookCall extends BaseModel
{
    use LogsActivity;

    protected static $logAttributes = ['event_name', 'processed'];

    protected $casts = [
        'payload' => 'array',
        'exception' => 'array',
        'processed' => 'boolean',
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at'
    ];

    protected $guarded = ['id'];

    /**
     * @throws WebhookFailed
     */
    public function process()
    {
        $this->clearException();

        if (empty($this->event_name)) {
            throw WebhookFailed::missingEventName($this);
        }
        $jobClass = $this->determineJobClass($this->event_name);
        if ($jobClass) {
            dispatch(new $jobClass($this));
        } else {
            throw WebhookFailed::invalidEventName($this);
        }
    }

    /**
     * @param Exception $exception
     * @return $this
     */
    public function saveException(Exception $exception)
    {
        $this->exception = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        $this->save();

        return $this;
    }

    protected function determineJobClass(string $eventName)
    {
        return Webhooks::getEventJob($eventName);
    }

    protected function clearException()
    {
        $this->exception = null;
        $this->save();
        return $this;
    }

    public function markAsProcessed()
    {
        $this->fill(['processed' => true])->save();
    }
}
