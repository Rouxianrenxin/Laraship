<?php

namespace Corals\Modules\Advert\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class VisitorDetail extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'advert_imp_visitor_details';

    protected $casts = [
        'is_phone' => 'boolean',
        'is_tablet' => 'boolean',
        'is_desktop' => 'boolean',
        'is_robot' => 'boolean',
        'languages' => 'json',
        'extras' => 'json',
    ];

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'advert.models.visitor_detail';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function impression()
    {
        return $this->belongsTo(Impression::class);
    }

    public function formattedDetails()
    {
        $keys = [
            'browser',
            'browser_version',
            'is_phone',
            'is_tablet',
            'is_desktop',
            'is_robot',
            'robot',
            'device',
            'platform',
            'platform_version',
            'languages',
            'extras',
        ];

        $details = '<table class="visitor-details">';

        foreach ($keys as $key) {
            $keyTitle = str_replace('_', ' ', title_case($key));

            $details .= "<tr><td>{$keyTitle}</td>";

            $value = $this->attributes[$key];

            if (isset($this->casts[$key])) {
                $cast = $this->casts[$key];
                if ($cast == 'boolean') {
                    $value = $this->attributes[$key] ? '&#10004;' : '&#10008;';
                } elseif ($cast == 'json') {
                    $value = $this->attributes[$key];
                }
            }

            if (empty($value)) {
                $value = '-';
            }

            $details .= "<td><b>{$value}</b></td>";
        }

        $details .= '</table>';

        return $details;
    }
}
