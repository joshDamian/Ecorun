<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Events\SentMessage;

class Talk extends Component
{
    use AuthorizesRequests;

    public $conversation;
    public Profile $me;
    public $message;
    protected $rules = [
        'message' => ['required']
    ];

    public function getListeners()
    {
        return [
            "echo-private:private_conversation.{$this->conversation->id},SentMessage" => '$refresh',
            'newSentMessage' => '$refresh'
        ];
    }

    public function mount()
    {
        $this->authorize('view', [$this->conversation, $this->me]);
    }

    public function getPartnerProperty()
    {

        return $this->conversation->pair->firstWhere('id', '!==', $this->me->id);
    }

    public function sendMessage($body)
    {
        $this->message = $body;
        $this->validate();
        $this->new_message->content = $this->message;
        $this->conversation->messages->push($this->new_message);
        $this->emit('newSentMessage');
        $this->new_message->save();
        broadcast(new SentMessage($this->new_message))->toOthers();
        return $this->done();
    }

    public function getNewMessageProperty()
    {
        return  Cache::rememberForever('new_message_model_for_sender_' . $this->me->id, function () {
            return (new Message())->forceFill([
                'sender_id' => $this->me->id,
                'messageable_type' => get_class($this->conversation),
                'messageable_id' => $this->conversation->id
            ]);
        });
    }

    public function done()
    {
        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.connect.conversation.talk', [
            'messages' => $this->conversation->messages->sortByDesc('created_at')->take(10)->reverse()
        ]);
    }
}
