<?php

namespace App\Listeners;

use App\Events\CommentedOnPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Post;
use App\Notifications\CommentedOnPostNotification;
use App\Notifications\MentionedInComment;
use Illuminate\Support\Facades\Notification;
use App\Models\Profile;

class SendCommentedOnPostNotification implements ShouldQueue
{
    private $notifiables;
    private $data;
    /**
    * Create the event listener.
    *
    * @return void
    */
    public function __construct() {
        //
    }

    /**
    * Handle the event.
    *
    * @param  CommentedOnPost  $event
    * @return void
    */
    public function handle(CommentedOnPost $event) {
        $this->data['comment'] = $event->comment;
        return $this->extractData()->getNotifiables()->sendNotifToPostFollowers()->sendSpecificNotif('mention');
    }

    private function extractData() {
        $this->data['post'] = $this->data['comment']->feedbackable->loadMissing('comments.profile', 'comments.replies.profiles');
        $this->data['comment_profiles'] = $this->data['post']->comments->pluck('profile.id')->filter()->unique();
        $this->data['replies_profiles'] = $this->data['post']->comments->pluck('replies.profile.id')->filter()->unique();
        $this->data['commenter_followers'] = $this->data['comment']->profile->followers->pluck('id')->filter()->unique();
        $this->data['comment_mentions'] = $this->data['comment']->mentions->diff([$this->data['comment']->profile->id]);
        return $this;
    }

    private function getNotifiables() {
        $profiles = Profile::whereIn('id', $this->data['comment_profiles']->merge($this->data['replies_profiles'])->merge($this->data['commenter_followers'])->merge($this->data['comment_mentions'])->diff([$this->data['comment']->profile->id]))->get();
        $this->notifiables['post_followers'] = $profiles->reject(function($profile) {
            return $this->data['comment']->mentions->contains($profile->id);
        });
        $this->notifiables['mentioned_in_comment'] = $profiles->filter(function($profile) {
            return $this->data['comment']->mentions->contains($profile->id);
        });
        return $this;
    }

    private function sendNotifToPostFollowers() {
        Notification::send($this->notifiables['post_followers'], new CommentedOnPostNotification($this->data['comment']));
        return $this;
    }

    private function sendSpecificNotif($key) {
        switch ($key) {
            case('mention'):
                Notification::send($this->notifiables['mentioned_in_comment'], new MentionedInComment($this->data['comment']));
                break;
        }
        return $this;
    }
}