<?php

namespace App\Listeners;

use App\Events\RepliedToComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\RepliedToComment as RepliedToCommentNotification;
use App\Notifications\MentionedInComment;
use Illuminate\Support\Facades\Notification;
use App\Models\Connect\Profile\Profile;


class SendRepliedToCommentNotification
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
     * @param  RepliedToComment  $event
     * @return void
     */
    public function handle(RepliedToComment $event)
    {
        $this->data['reply'] = $event->reply;
        $this->data['post'] = $this->data['reply']->feedbackable->feedbackable;
        return $this->getNotifiables()->sendNotifToPostFollowers()->sendSpecificNotif('mentions');
    }

    private function getNotifiables()
    {
        $profiles = $this->data['post']->followers->except([$this->data['reply']->profile_id]);
        $this->notifiables['post_followers'] = $profiles->merge($this->data['reply']->profile->followers)->flatten()->reject(function ($profile) {
            return $this->data['reply']->mentions->contains($profile->id);
        })->unique();
        $this->notifiables['mentioned_in_reply'] = Profile::whereIn('id', $this->data['reply']->mentions)->distinct()->get();
        return $this;
    }

    private function sendNotifToPostFollowers()
    {
        Notification::send($this->notifiables['post_followers'], new RepliedToCommentNotification($this->data['reply']));
        return $this;
    }

    private function sendSpecificNotif($key)
    {
        switch ($key) {
            case ('mentions'):
                Notification::send($this->notifiables['mentioned_in_reply'], new MentionedInComment($this->data['reply']));
                break;
        }
        return $this;
    }
}
