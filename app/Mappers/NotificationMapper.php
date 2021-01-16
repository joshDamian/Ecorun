<?php

namespace App\Mappers;

trait NotificationMapper
{
    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    public function all()
    {
        return $this->notifications;
    }

    public function grouped_by_type()
    {
        return $this->notifications->groupBy('type');
    }

    public function grouped_by_notifiable()
    {
        return $this->notifications->groupBy('notifiable_id');
    }

    public function unread_count()
    {
        return $this->notifications->filter(function ($notif) {
            return $notif->read_at === null;
        })->count();
    }

    public function types()
    {
        return $this->grouped_by_type->keys();
    }
}
