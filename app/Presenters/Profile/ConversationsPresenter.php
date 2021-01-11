<?php

namespace App\Presenters\Profile;

use App\DataBanks\Profile\ConversationsDatabank;
use App\Models\Profile;

class ConversationsPresenter
{
    protected Profile $profile;
    protected $conversations;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->conversations = (new ConversationsDatabank($this->profile))->fetch();
    }

    public function all()
    {
        return $this->conversations->sortBy('updated_at');
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    public function groups()
    {
        return $this->conversations->filter(function ($conversation) {
            return $conversation->type === "group_conversation";
        });
    }
}
