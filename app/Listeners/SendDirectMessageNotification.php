<?php

namespace App\Listeners;

use App\Events\NewMessageForProfile;
use App\Events\ConversationEvents\SentMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDirectMessageNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SentMessage  $event
     * @return void
     */
    public function handle(SentMessage $event)
    {
        $message = $event->message;
        if ($message->messageable_type === 'App\Models\Connect\Conversation\DirectConversation') {
            $concerned_profile = $message->messageable->pair->firstWhere('id', '!==', $message->sender_id);
            broadcast(new NewMessageForProfile($concerned_profile))->toOthers();
        }
    }
}
