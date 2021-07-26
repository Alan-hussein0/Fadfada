<?php

namespace App\Models;
use Illuminate\database\Eloquent\Collection;


class MessageCollection extends Collection
{

    public function markAsRead()
    {
        $this->each->markAsRead();
    }

    /**
     * Mark all messages as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        $this->each->markAsUnread();
    }
}
