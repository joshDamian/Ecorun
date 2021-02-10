<?php

namespace App\Http\Livewire\Connect\Conversation;

use App\Models\Profile;
use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Events\SentMessage;
use Illuminate\Validation\Rule;
use App\Http\Livewire\Traits\MultipleImageSelector;
use App\Http\Livewire\Traits\UploadPhotos;

class Talk extends Component
{
    use AuthorizesRequests,
    UploadPhotos,
    MultipleImageSelector;

    public $conversation;
    public Profile $me;
    public string $message_to_send = '';
    public $photos = [];
    public int $perPage = 10;
    protected $rules = [
        'message_to_send' => ['required']
    ];

    public function validationRules() {
        return [
            'message_to_send' => Rule::requiredIf((count($this->photos) < 1)),
            'photos' => [
                'array',
                Rule::requiredIf((empty(trim($this->message_to_send))))
            ],
            'photos.*' => $this->image_validation
        ];
    }

    public function getListeners() {
        return [
            'reloadMessages',
            'markReceivedMessagesRead'
        ];
    }

    public function mount() {
        $this->authorize('view', [$this->conversation, $this->me]);
    }

    public function reloadMessages() {
        return $this->conversation->messages->fresh();
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
        $this->validate($this->validationRules());
        $this->new_message->content = trim($this->message_to_send);
        $this->conversation->messages->push($this->new_message);
        $this->new_message->save();
        if (count($this->photos) > 0) {
            $this->uploadPhotos('message-photos', $this->new_message, 'message_photo');
        }
        $this->reset('message_to_send');
        broadcast(new SentMessage($this->new_message))->toOthers();
        return;
    }

    public function getNewMessageProperty() {
        return (new Message())->forceFill([
            'sender_id' => $this->me->id,
            'messageable_type' => get_class($this->conversation),
            'messageable_id' => $this->conversation->id
        ]);
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