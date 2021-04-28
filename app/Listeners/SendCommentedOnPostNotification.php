<?php

namespace App\Listeners;

use App\Events\CommentedOnPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\CommentedOnPostNotification;
use App\Notifications\MentionedInComment;
use Illuminate\Support\Facades\Notification;
use App\Models\Connect\Profile\Profile;

class SendCommentedOnPostNotification
{

    private $notifiables;
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
     * @param  CommentedOnPost  $event
     * @return void
     */
    public function handle(CommentedOnPost $event)
    {
        $this->data['comment'] = $event->comment;
        $this->data['post'] = $this->data['comment']->feedbackable;
        return $this->getNotifiables()->sendNotifToPostFollowers()->sendNotifToCommentMentions();
    }

    private function getNotifiables()
    {
        $profiles = $this->data['post']->followers->except([$this->data['comment']->profile_id]);
        $this->notifiables['post_followers'] = $profiles->merge($this->data['comment']->profile->followers)->flatten()->reject(function ($profile) {
            return $this->data['comment']->mentions->contains($profile->id);
        })->unique();
        $this->notifiables['mentioned_in_comment'] = Profile::whereIn('id', $this->data['comment']->mentions)->where('id', '!=', $this->data['comment']->profile_id)->distinct()->get();
        return $this;
    }

    private function sendNotifToPostFollowers()
    {
        Notification::send($this->notifiables['post_followers'], new CommentedOnPostNotification($this->data['comment']));
        return $this;
    }

    private function sendNotifToCommentMentions()
    {
        Notification::send($this->notifiables['mentioned_in_comment'], new MentionedInComment($this->data['comment']));
        return $this;
    }
}
