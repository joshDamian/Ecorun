<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\PostCreated as NotificationsPostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPostWebNotificaton
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
     * @param  PostCreated $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $followers = $event->post->profile->followers->except([$event->post->profile->id]);

        Notification::send($followers, new NotificationsPostCreated($event->post));
    }
}
