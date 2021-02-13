<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Feedback;

class CommentedOnPost implements ShouldBroadcast
{
    use Dispatchable,
    InteractsWithSockets,
    SerializesModels;

    public Feedback $comment;
    /**
    * Create a new event instance.
    *
    * @return void
    */
    public function __construct(Feedback $comment) {
        $this->comment = $comment->loadMissing('feedbackable', 'profile.followers');
    }

    /**
    * Get the channels the event should broadcast on.
    *
    * @return \Illuminate\Broadcasting\Channel|array
    */
    public function broadcastOn() {
        return new Channel('postChannel.' . $this->comment->feedbackable_id);
    }

    /**
    * Get the data to broadcast.
    *
    * @return array
    P     */
    public function broadcastWith() {
        return [];
    }
}