<?php

namespace Corals\Settings\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\Cache\Cachable;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class ModelSetting extends BaseModel
{
    use PresentableTrait, LogsActivity, Cachable;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'settings.models.setting';

    protected static $logAttributes = ['value'];

    protected $guarded = ['id'];

    protected $casts = [

    ];

    protected $table = "model_settings";


    public function getFilePath()
    {
        return config('settings.upload_path') . '/' . $this->attributes['value'];
    }


}
