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
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class RepliedToComment implements ShouldBroadcastNow
{
    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    public Feedback $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Feedback $reply)
    {
        $this->reply = $reply->loadMissing('profile.followers', 'feedbackable.feedbackable');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('commentChannel.' . $this->reply->feedbackable_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [];
    }
}
