<?php

namespace Corals\User\Communication\Models;


use Illuminate\Notifications\DatabaseNotification;

/**
 * Class Notification
 * @package Corals\User\Communication\Models
 * @property integer type
 * @property integer notifiable_id
 * @property string notifiable_type
 * @property array data
 * @property string read_at
 * @method markAsUnread()
 * @method read()
 * @method unread()
 *
 */
class Notification extends DatabaseNotification
{

    /**
     * Toggle Read at of a notification
     *
     */
    public function toggleReadAt()
    {
        $this->unread() ? $this->markAsRead() : $this->markAsUnread();
    }
}