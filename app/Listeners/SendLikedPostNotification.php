<?php

namespace App\Listeners;

use App\Events\LikedPost;
use App\Notifications\LikedPost as NotificationsLikedPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendLikedPostNotification
{
    private $data;
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
     * @param  LikedPost  $event
     * @return void
     */
    public function handle(LikedPost $event)
    {
        $this->data['like'] = $event->like;
        $this->data['post'] = $this->data['like']->likeable;
        return $this->getNotifiables()->sendNotifToPostFollowers();
    }

    private function getNotifiables()
    {
        $this->notifiables['post_followers'] = $this->data['post']->followers->except([$this->data['like']->profile_id]);
        return $this;
    }

    private function sendNotifToPostFollowers()
    {
        Notification::send($this->notifiables['post_followers'], new NotificationsLikedPost($this->data['like']));
        return $this;
    }
}
