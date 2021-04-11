<?php

namespace App\Presenters\Profile;

use App\DataBanks\Profile\ConversationsDataBank;
use App\Models\DirectConversation;
use App\Models\GroupConversation;
use App\Models\Profile;
use App\Presenters\Presenter;

class ConversationsPresenter
{
    use Presenter;

    protected Profile $profile;
    protected $conversations;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->conversations = (new ConversationsDataBank($this->profile))->fetch();
    }

    public function all()
    {
        return $this->conversations->flatten();
    }

    public function groups()
    {
        return $this->conversations[GroupConversation::class];
    }

    public function directConversations()
    {
        return $this->conversations[DirectConversation::class];
    }

    public function activeConversations()
    {
        return $this->all->filter(function ($conversation) {
            return $conversation->messages->count() > 0;
        });
    }
}
