<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use App\Models\Message;
use Livewire\Component;

class Talk extends Component
{
    public $conversation;
    public Profile $me;
    public $message;
    protected $rules = [
        'message' => ['required']
    ];
    protected $listeners = [
        'newMessage' => '$refresh'
    ];

    public function getPartnerProperty()
    {
        return $this->conversation->pair->firstWhere('id', '!==', $this->me->id);
    }

    public function sendMessage()
    {
        $this->validate();
        $message = new Message();
        $message->forceFill([
            'content' => $this->message,
            'sender_id' => $this->me->id,
            'messageable_type' => get_class($this->conversation),
            'messageable_id' => $this->conversation->id
        ])->save();
        $this->done();
        $this->emitSelf('newMessage');
    }

    public function done()
    {
        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.connect.conversation.talk');
    }
}
