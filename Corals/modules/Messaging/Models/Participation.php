<?php

namespace Corals\Modules\Messaging\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Corals\Modules\Messaging\Contracts\Participation as ParticipationContract;

class Participation extends BaseModel implements ParticipationContract
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'messaging.models.participation';

    protected static $logAttributes = [];

    protected $fillable = ['discussion_id', 'participable_type', 'participable_id', 'last_read', 'status'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_read'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'integer',
        'discussion_id'   => 'integer',
        'participable_id' => 'integer',
    ];

    protected $table = 'messaging_participations';

    public function getModuleName()
    {
        return 'Messaging';
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Discussion relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Participable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function participable()
    {
        return $this->morphTo();
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the participable string info.
     *
     * @return string
     */
    public function stringInfo()
    {
        return $this->participable->getAttribute('name');
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        // TODO: Implement restore() method.
    }


    public function canBeRead()
    {
        return in_array($this->status, ['unread', 'important', 'star']);
    }

    public function canBeUnRead()
    {
        return in_array($this->status, ['read', 'important', 'star']);
    }

    public function canBeImportant()
    {
        return in_array($this->status, ['read', 'unread', 'star']);
    }

    public function canBeStar()
    {
        return in_array($this->status, ['read', 'unread', 'important']);
    }
}
