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
    public int $perPage = 10;
    protected $rules = [
        'message' => ['required']
    ];

    public function getListeners() {
        return [
            "echo-private:private_conversation.{$this->conversation->id},SentMessage" => '$refresh',
            'SentAMessage' => '$refresh'
        ];
    }

    public function mount() {
        $this->authorize('view', [$this->conversation, $this->me]);
    }

    public function getPartnerProperty() {

        return $this->conversation->pair->firstWhere('id', '!==', $this->me->id);
    }

    public function markReceivedMessagesRead() {
        $marked_count = $this->conversation->messages->where('sender_id', '!==', $this->me->id)->reject(function($message) {
            return $message->seenBy->pluck('id')->contains($this->me->id);
        })->each(function ($message) {
            $message->seenBy()->save($this->me);
            $message->flushQueryCache();
        })->count();
        if ($marked_count > 0) {
            return $this->emit('readMessages');
        }
        return;
    }

    public function sendMessage($body) {
        $this->message = $body;
        $this->validate();
        $this->new_message->content = trim($this->message);
        $this->conversation->messages->push($this->new_message);
        $this->emit('SentAMessage');
        $this->new_message->save();
        broadcast(new SentMessage($this->new_message))->toOthers();
        return $this->done();
    }

    public function getNewMessageProperty() {
        return  Cache::rememberForever('new_message_model_for_sender_' . $this->me->id,
            function () {
                return (new Message())->forceFill([
                    'sender_id' => $this->me->id,
                    'messageable_type' => get_class($this->conversation),
                    'messageable_id' => $this->conversation->id
                ]);
            });
    }

    public function done() {
        $this->reset('message');
    }

    public function loadOlderMessages() {
        return $this->perPage = $this->perPage + 10;
    }

    public function render() {
        return view('livewire.connect.conversation.talk',
            [
                'messages' => $this->conversation->messages->sortByDesc('created_at')->take($this->perPage)->reverse(),
                'messages_count' => $this->conversation->messages->count()
            ]);
    }
}