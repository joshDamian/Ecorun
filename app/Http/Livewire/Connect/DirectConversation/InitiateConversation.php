<?php

namespace App\Http\Livewire\Connect\DirectConversation;

use Livewire\Component;
use App\Models\Profile;
use App\Models\DirectConversation;
use App\Models\Message;
use App\Events\SentMessage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InitiateConversation extends Component
{
    use AuthorizesRequests;

    public Profile $initiator;
    public Profile $joined;
    public $message;
    public $should_display = false;
    public $display_sent = false;
    protected $rules = [
        'message' => ['required']
    ];
    protected $listeners = [
        'close',
        'newConvo'
    ];

    public function done()
    {
        $this->reset('message');
        $this->resetValidation();
    }

    public function close()
    {
        $this->should_display = false;
        return $this->done();
    }

    public function newConvo()
    {
        $this->display_sent = true;
        return $this->done();
    }

    public function initiate()
    {
        $this->authorize('create', [DirectConversation::class, $this->initiator, $this->joined]);
        $this->validate();
        $conversation = DirectConversation::forceCreate([
            'initiator_id' => $this->initiator->id,
            'joined_id' => $this->joined->id
        ]);
        $message = Message::forceCreate([
            'content' => $this->message,
            'sender_id' => $this->initiator->id,
            'messageable_type' => get_class($conversation),
            'messageable_id' => $conversation->id
        ]);
        $this->emit('newConvo');
        broadcast(new SentMessage($message))->toOthers();
        return;
    }

    public function render()
    {
        return view('livewire.connect.direct-conversation.initiate-conversation');
    }
}
