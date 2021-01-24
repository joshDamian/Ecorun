<?php

namespace App\Listeners;

use App\Events\ContentShared;
use App\Events\NewFeedContentForProfile;
use App\Notifications\ContentShared as NotificationsContentShared;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendContentSharedNotification
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
     * @param  ContentShared  $event
     * @return void
     */
    public function handle(ContentShared $event)
    {
        $followers = $event->share->loadMissing('profile.followers')->profile->followers;
        Notification::send($followers, new NotificationsContentShared($event->share));
        foreach ($followers as $follower) {
            broadcast(new NewFeedContentForProfile($follower))->toOthers();
        }
    }
}
