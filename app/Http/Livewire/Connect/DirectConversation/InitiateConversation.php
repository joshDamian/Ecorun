<?php

namespace App\Http\Livewire\Connect\DirectConversation;

use Livewire\Component;
use App\Models\Profile;
use App\Models\DirectConversation;
use App\Models\Message;

class InitiateConversation extends Component
{
    public Profile $initiator;
    public Profile $joined;
    public $message;
    public $should_display = true;
    protected $rules = [
        'message' => ['required']
    ];
    protected $listeners = [
        'done'
    ];

    public function done() {
        $this->reset('message');
        $this->resetValidation();
    }

    public function initiate() {
        $this->validate();
        $conversation = new DirectConversation();

        $conversation = $conversation->forceFill([
            'initiator_id' => $this->initiator->id,
            'joined_id' => $this->joined->id
        ]);

        $message = new Message();

        $message->forceFill([
            'content' => $this->message,
            'messageable_type' => get_class($conversation),
            'messageable_id' => $conversation->id
        ]);

        $this->emit('done');
        return $this->done();
    }

    public function render() {
        return view('livewire.connect.direct-conversation.initiate-conversation');
    }
}