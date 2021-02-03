<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Events\SentMessage;
use App\Http\Livewire\Traits\MultipleImageSelector;
use App\Http\Livewire\Traits\UploadPhotos;

class Talk extends Component
{
    use AuthorizesRequests,
    UploadPhotos,
    MultipleImageSelector;

    public $conversation;
    public Profile $me;
    public $message = '';
    public $photos = [];
    public int $perPage = 10;
    protected $rules = [
        'message' => ['required']
    ];

    public function getListeners() {
        return [
            'SentAMessage' => '$refresh',
            'refresh' => '$refresh',
            'markReceivedMessagesRead'
        ];
    }

    public function mount() {
        $this->authorize('view', [$this->conversation, $this->me]);
    }

    public function getPartnerProperty() {

        return $this->conversation->pair->firstWhere('id', '!==', $this->me->id);
    }

    public function markReceivedMessagesRead() {
        $marked_count = $this->conversation->messages->where('sender_id', '!==', $this->me->id)->reject(function ($message) {
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

    public function sendMessage() {
        $this->validate();
        $this->new_message = new Message();
        $this->new_message->sender_id = $this->me->id;
        $this->new_message->messageable_type = get_class($this->conversation);
        $this->new_message->content = trim($this->message);
        $this->new_message->messageable_id = $this->conversation->id;
        $this->conversation->messages->push($this->new_message);
        $this->emit('SentAMessage');
        $this->done();
        $this->new_message->save();
        broadcast(new SentMessage($this->new_message))->toOthers();
        return;
    }


    public function done() {
        $this->reset('message');
    }

    public function loadOlderMessages() {
        return $this->perPage = $this->perPage + 10;
    }

    public function render() {
        return view(
            'livewire.connect.conversation.talk',
            [
                'messages' => $this->conversation->messages->sortByDesc('created_at')->take($this->perPage)->reverse(),
                'messages_count' => $this->conversation->messages->count()
            ]
        );
    }
}