<?php

namespace App\Listeners;

use App\Events\NewFeedContentForProfile;
use App\Events\PostCreated;
use App\Notifications\PostCreated as NotificationsPostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MentionedInPost;
use App\Models\Profile;

class SendPostCreatedNotificaton
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
        $followers = $event->post->loadMissing('profile.followers')->profile->followers;
        $mentions = $event->post->mentions->diff([$event->post->profile->id]);
        $toSendPostCreated = $followers->whereNotIn('id', $mentions);
        $toSendMentionedInPost = Profile::whereIn('id', $mentions)->get();
        Notification::send($toSendPostCreated, new NotificationsPostCreated($event->post));
        Notification::send($toSendMentionedInPost, new MentionedInPost($event->post));
        foreach ($toSendMentionedInPost->merge($toSendPostCreated)->all() as $to_notify) {
            broadcast(new NewFeedContentForProfile($to_notify))->toOthers();
        }
    }
}
