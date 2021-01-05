<?php

namespace App\Presenters\User;

use App\DataBanks\User\NotificationsDataBank;
use App\Mappers\NotificationMapper;
use App\Models\User;

class NotificationsPresenter
{
    use NotificationMapper;

    protected User $user;
    protected $notifications;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->notifications = (new NotificationsDataBank($this->user))->fetch();
    }
}
