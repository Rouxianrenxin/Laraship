<?php

namespace Corals\Modules\Messaging\Hooks;

use Corals\Modules\Messaging\Models;
use Illuminate\Database\Eloquent\Builder;


Class Messagable
{

    protected $inboxStatuses = ['read', 'unread', 'important', 'star'];
    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * @param null $status
     */
    public function discussions()
    {
        $inboxStatuses = $this->inboxStatuses;

        return function ($status = null, $params = []) use ($inboxStatuses) {


            $morphToMany = $this->morphToMany(
                Models\Discussion::class,
                'participable',
                'messaging_participations'
            );

            if ($status) {
                $morphToMany->wherePivot('status', $status);
            } else {
                $morphToMany->wherePivotIn('status', $inboxStatuses);
            }

            if (isset($params['getData']) && $params['getData']) {
                return $morphToMany->getResults();
            } else {
                return $morphToMany;

            }
        };
    }

    /**
     * Participations relationship.
     *
     */
    public function participations()
    {
        return function ($params = []) {

            $relation = $this->morphMany(
                Models\Participation::class,
                'participable'
            );
            if (isset($params['getData']) && $params['getData']) {
                return $relation->getResults();
            } else {
                return $relation;

            }
        };
    }

    /**
     * Message relationship.
     *
     */
    public function messages()
    {
        return function ($params = []) {
            $relation = $this->morphMany(
                Models\Message::class,
                'participable'
            );
            if (isset($params['getData']) && $params['getData']) {
                return $relation->getResults();
            } else {
                return $relation;

            }
        };
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Returns the new messages count for user.
     *
     */
    public function newMessagesCount()
    {
        return function ($params = []) {

            return $this->discussionsWithNewMessages()->count();
        };
    }

    /**
     * Returns all discussions IDs with new messages.
     *
     */
    public function discussionsWithNewMessages()
    {
        return function ($params = []) {

            $participationsTable = 'messaging_participations';
            $discussionsTable = 'messaging_discussions';


            return $this->discussions()->where(function (Builder $query) use ($participationsTable, $discussionsTable) {
                $query->whereNull("$participationsTable.last_read");
                $query->orWhere(
                    "$discussionsTable.updated_at", '>', $this->getConnection()->raw("$participationsTable.last_read")
                );
            })->get();
        };
    }


}
