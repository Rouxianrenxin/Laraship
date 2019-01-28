<?php

namespace Corals\Modules\Messaging\Models;

use Corals\Foundation\Models\BaseModel;

use Corals\Foundation\Search\Indexable;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Messaging\Contracts\Discussion as DiscussionContract;
use Corals\Modules\Messaging\Contracts\Message as MessageContract;
use Corals\Modules\Messaging\Contracts\Participation as ParticipationContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Corals\User\Models\User;

/**
 * @method \Illuminate\Database\Eloquent\Builder subject(string $subject, bool $strict)
 * @method \Illuminate\Database\Eloquent\Builder between(array $participablesIds)
 * @method \Illuminate\Database\Eloquent\Builder forUser(int $participableId)
 * @method \Illuminate\Database\Eloquent\Builder forUserWithNewMessages(int $participableId)
 */
class Discussion extends BaseModel implements DiscussionContract
{
    use Indexable, PresentableTrait, LogsActivity;
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'messaging.models.discussion';

    protected static $logAttributes = ['subject'];

    protected $fillable = ['subject'];

    protected $casts = [
        'id' => 'integer',
    ];

    protected $indexContentColumns = ['messages.body'];
    protected $indexTitleColumns = ['subject'];

    protected $table = 'messaging_discussions';

    public function getModuleName()
    {
        return 'Messaging';
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function getUserParticipation($user = null)
    {
        if (is_null($user)) {
            $user = user();
        }

        return $this->hasMany(Participation::class)
            ->where("participable_type", '=', $user->getMorphClass())
            ->where("participable_id", '=', $user->getKey())
            ->first();
    }

    /**
     * Messages relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('messaging_messages.created_at', 'desc');
    }

    /**
     * Get the participable that created the first message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return User::where('id', $this->created_by)->first();
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope discussions that the participable is associated with.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeForUser(Builder $query, EloquentModel $participable)
    {
        $table = $this->getParticipationsTable();

        return $query->join($table, function (JoinClause $join) use ($table, $participable) {
            $morph = 'participable';

            $join->on($this->getQualifiedKeyName(), '=', "{$table}.discussion_id")
                ->where("{$table}.{$morph}_type", '=', $participable->getMorphClass())
                ->where("{$table}.{$morph}_id", '=', $participable->getKey())
                ->whereNull("{$table}.deleted_at");
        });
    }

    /**
     * Scope discussions to load participations relationship.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeWithParticipations(Builder $query)
    {
        return $query->with(['participations']);
    }

    /**
     * Scope discussions with new messages that the participable is associated with.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeForUserWithNewMessages(Builder $query, EloquentModel $participable)
    {
        $prefix = $this->getConnection()->getTablePrefix();
        $participations = $this->getParticipationsTable();
        $discussions = $this->getTable();

        return $this->scopeForUser($query, $participable)
            ->where(function (Builder $query) use ($participations, $discussions, $prefix) {
                $expression = $this->getConnection()->raw("{$prefix}{$participations}.last_read");

                $query->where("{$discussions}.updated_at", '>', $expression)
                    ->orWhereNull("{$participations}.last_read");
            });
    }

    /**
     * Scope discussions between given participables.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Support\Collection|array $participables
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeBetween(Builder $query, $participables)
    {
        return $query->whereHas($this->getParticipationsTable(), function (Builder $query) use ($participables) {
            $morph = 'participable';
            $index = 0;

            foreach ($participables as $participable) {
                /** @var  \Illuminate\Database\Eloquent\Model $participable */
                $clause = [
                    ["{$morph}_type", '=', $participable->getMorphClass()],
                    ["{$morph}_id", '=', $participable->getKey()],
                ];

                $query->where($clause, null, null, $index === 0 ? 'and' : 'or');

                $index++;
            }

            $query->groupBy('discussion_id')
                ->havingRaw('COUNT(discussion_id)=' . count($participables));
        });
    }

    /**
     * Scope the query by the subject.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $subject
     * @param  bool $strict
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeSubject(Builder $query, $subject, $strict = false)
    {
        return $query->where('subject', 'like', $strict ? $subject : "%{$subject}%");
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the latest_message attribute.
     *
     */
    public function getLatestMessageAttribute()
    {
        return $this->messages->sortByDesc('created_at')->first();
    }

    /**
     * Get the participations table name.
     *
     * @return string
     */
    protected function getParticipationsTable()
    {
        return 'messaging_participations';
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Returns all of the latest discussions by `updated_at` date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getLatest()
    {
        return self::query()->latest('updated_at')->get();
    }

    /**
     * Returns all discussions by subject.
     *
     * @param  string $subject
     * @param  bool $strict
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getBySubject($subject, $strict = false)
    {
        return self::subject($subject, $strict)->get();
    }

    /**
     * Returns an array of participables that are associated with the discussion.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParticipables()
    {
        return $this->participations()
            ->get()
            ->transform(function (ParticipationContract $participant) {
                return $participant->participable;
            })
            ->unique(function (EloquentModel $participable) {
                return $participable->getMorphClass() . '-' . $participable->getKey();
            });
    }

    /**
     * Add a participable to discussion.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     */
    public function addParticipant(EloquentModel $participable)
    {
        $morph = 'participable';

        return $this->participations()->firstOrCreate([
            "{$morph}_id" => $participable->getKey(),
            "{$morph}_type" => $participable->getMorphClass(),
            'discussion_id' => $this->id,
        ]);
    }

    /**
     * Add many participables to discussion.
     *
     * @param  \Illuminate\Support\Collection|array $participables
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function addParticipants($participables)
    {
        foreach ($participables as $participable) {
            $this->addParticipant($participable);
        }

        return $this->participations;
    }

    /**
     * Remove a participable from discussion.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     * @param  bool $reload
     *
     * @return int
     */
    public function removeParticipant(EloquentModel $participable, $reload = true)
    {
        return $this->removeParticipants([$participable], $reload);
    }

    /**
     * Remove many participables from discussion.
     *
     * @param  \Illuminate\Support\Collection|array $participables
     * @param  bool $reload
     *
     * @return int
     */
    public function removeParticipants($participables, $reload = true)
    {
        $morph = 'participable';
        $deleted = 0;

        foreach ($participables as $participable) {

            /** @var  \Illuminate\Database\Eloquent\Model $participable */
            $deleted += $this->participations()
                ->where("{$morph}_type", '=', $participable->getMorphClass())
                ->where("{$morph}_id", '=', $participable->getKey())
                ->where('discussion_id', '=', $this->id)
                ->delete();
        }

        if ($reload)
            $this->load(['participations']);

        return $deleted;
    }

    /**
     * Mark a discussion as read for a participable.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     * @return bool|int
     */
    public function markAsRead(EloquentModel $participable)
    {
        if ($participant = $this->getParticipationByParticipable($participable)) {
            return $participant->update(['last_read' => Carbon::now()]);
        }

        return false;
    }

    /**
     * See if the current thread is unread by the participable.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     * @return bool
     */
    public function isUnread(EloquentModel $participable)
    {
        return ($participant = $this->getParticipationByParticipable($participable))
            ? $participant->last_read < $this->updated_at
            : false;
    }

    /**
     * Finds the participant record from a participable model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     */
    public function getParticipationByParticipable(EloquentModel $participable)
    {
        $morph = 'participable';

        return $this->participations()
            ->where("{$morph}_type", '=', $participable->getMorphClass())
            ->where("{$morph}_id", '=', $participable->getKey())
            ->first();
    }

    /**
     * Get the trashed participations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTrashedParticipations()
    {
        return $this->participations()->get();
    }

    /**
     * Restores all participations within a discussion.
     *
     * @param  bool $reload
     *
     * @return int
     */
    public function restoreAllParticipations($reload = true)
    {
        $restored = $this->getTrashedParticipations()
            ->filter(function (ParticipationContract $participant) {
                return $participant->restore();
            })
            ->count();

        if ($reload)
            $this->load(['participations']);

        return $restored;
    }

    /**
     * Generates a participant information as a string.
     *
     * @param  \Closure|null $callback
     * @param  string $glue
     *
     * @return string
     */
    public function participationsString($callback = null, $glue = ', ')
    {
        /** @var \Illuminate\Database\Eloquent\Collection $participations */
        $participations = $this->participations->load(['participable']);

        if (is_null($callback)) {
            // By default: the participant name
            $callback = function (ParticipationContract $participant) {
                return $participant->stringInfo();
            };
        }

        return $participations->map($callback)->implode($glue);
    }

    /**
     * Checks to see if a participable is a current participant of the discussion.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     * @return bool
     */
    public function hasParticipation(EloquentModel $participable)
    {
        $morph = 'participable';
        return $this->participations()
                ->where("{$morph}_id", '=', $participable->getKey())
                ->where("{$morph}_type", '=', $participable->getMorphClass())
                ->count();

    }

    /**
     * Get the unread messages in discussion for a specific participable.
     *
     * @param  \Illuminate\Database\Eloquent\Model $participable
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUnreadMessages(EloquentModel $participable)
    {
        $participation = $this->getParticipationByParticipable($participable);

        if (is_null($participation))
            return new Collection;

        return is_null($participation->last_read)
            ? $this->messages->toBase()
            : $this->messages->filter(function (MessageContract $message) use ($participation) {
                return $message->updated_at->gt($participation->last_read);
            })->toBase();
    }

    public function toggleStatus($status)
    {
        $user = user();

        $this->participations()
            ->where("participable_type", '=', $user->getMorphClass())
            ->where("participable_id", '=', $user->getKey())
            ->update(['messaging_participations.status' => $status]);
    }

}
