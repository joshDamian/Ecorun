<?php

namespace App\DataBanks\User;

use App\DataBanks\DataBank;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsDataBank implements DataBank
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function fetch()
    {
        return DatabaseNotification::whereIn('notifiable_id', $this->user->associated_profiles->all->unique()->pluck('id'))->latest()->get();
    }
}
