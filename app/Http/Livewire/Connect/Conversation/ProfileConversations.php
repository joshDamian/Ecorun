<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ProfileConversations extends Component
{
    public Profile $profile;
    public $activeConversation;
    public string $sortBy = 'all';

    public function switchedChatProfile(Profile $profile) {
        $this->activeConversation = null;
        $this->profile = $profile;
    }

    public function getListeners() {
        return [
            'showAll',
            'switchedChatProfile',
            "echo-private:App.Models.Profile.{$this->profile->id},NewMessageForProfile" => '$refresh'
        ];
    }

    public function mount(?string $activeConversation = null) {
        $this->activeConversation = $this->conversations->all->firstWhere("secret_key", $activeConversation) ?? $activeConversation;
        return;
    }

    public function showAll() {
        return $this->activeConversation = false;
    }

    public function getConversationsProperty() {
        return $this->profile->conversations;
    }

    public function setSortBy(string $key) {
        $this->sortBy = $key;
    }

    public function switchActiveConv($id) {
        $this->activeConversation = $this->conversations->all->firstWhere("id", $id);
        return;
    }

    public function getCurrentConversationsProperty() {
        return $this->sortConversations($this->sortBy)->sortByDesc('updated_at');
    }

    public function sortConversations(string $key) {
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

    public function render() {
        return view('livewire.connect.conversation.profile-conversations');
    }
}