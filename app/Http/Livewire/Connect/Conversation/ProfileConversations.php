<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use Livewire\Component;

class ProfileConversations extends Component
{
    public Profile $profile;
    public string $sortBy = 'all';

    public function getConversationsProperty()
    {
        return $this->profile->conversations;
    }

    public function setSortBy(string $key)
    {
        $this->sortBy = $key;
    }

    public function getCurrentConversationsProperty()
    {
        return $this->sortConversations($this->sortBy)->sortByDesc('updated_at');
    }

    public function sortConversations(string $key)
    {
        switch ($key) {
            case ("groups"):
                return $this->conversations->groups;
                break;
            case ("dms"):
                return $this->conversations->directConversations;
                break;
            case ("all"):
            default:
                return $this->conversations->all;
                break;
        }
    }

    public function render()
    {
        return view('livewire.connect.conversation.profile-conversations');
    }
}
