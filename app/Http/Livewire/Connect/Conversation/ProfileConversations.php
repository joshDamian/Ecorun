<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Connect\Profile\Profile;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ProfileConversations extends Component
{
    public Profile $profile;
    public $activeConversation;
    public string $sortBy = 'all';
    protected $rules = [
        'activeConversation' => []
    ];

    public function switchedChatProfile(Profile $profile)
    {
        $this->activeConversation = null;
        $this->profile = $profile;
    }

    public function getListeners()
    {
        return [
            //'showAll',
            'switchedChatProfile',
        ];
    }

    public function mount(?string $activeConversation = null, Profile $me)
    {
        $this->me = $me;
        $this->activeConversation = $this->conversations->all->firstWhere("secret_key", $activeConversation) ?? $activeConversation;
        return;
    }

    /* public function showAll()
    {
        return $this->activeConversation = null;
    } */

    public function getConversationsProperty()
    {
        return $this->profile->conversations;
    }


    public function setSortBy(string $key)
    {
        $this->sortBy = $key;
    }

    public function switchActiveConv($secret)
    {
        $this->activeConversation = $this->conversations->all->firstWhere("secret_key", $secret);
        return;
    }

    public function getCurrentConversationsProperty()
    {
        return $this->sortConversations($this->sortBy)->sortByDesc('updated_at')->filter(function ($conversation) {
            return $conversation->messages->count() > 0;
        });
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
