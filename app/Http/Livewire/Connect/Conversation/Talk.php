<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Conversation;
use Livewire\Component;

class Talk extends Component
{
    public Profile $talkTo;
    public Profile $me;
    public $message;
    protected $rules = [
        'message' => ['required']
    ];

    public function mount()
    {
        $this->me = Auth::user()->profile;
        $this->talkTo = Profile::where('id', '!=', $this->me->id)->first();
    }

    public function sendMessage()
    {
        $this->validate();
        $message = new Message();
        $message->content = $this->message;
        $message->privacy_level = "all_members";
        $message = $this->me->messages()->save($message);
        $this->me->conversations->all->first()->messages()->save($message);
    }

    public function createConversation()
    {
        Conversation::create([
            'members' => [$this->me->id, $this->talkTo->id],
            'type' => "direct_conversation"
        ]);
    }

    public function render()
    {
        return view('livewire.connect.conversation.talk');
    }
}
