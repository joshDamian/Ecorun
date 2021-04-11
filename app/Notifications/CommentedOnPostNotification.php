<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Feedback;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class CommentedOnPostNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public Feedback $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Feedback $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'mail',
            'database',
            'broadcast',
            WebPushChannel::class
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'New comment alert',
            'model_key' => $this->comment->id
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        $comment = $this->comment;
        $post = $comment->feedbackable;
        $refrence_phrase = $post->profile->id === $notifiable->id ? 'your post' : (($post->profile_id === $comment->profile_id) ? 'their post' : 'a post you\'re following');
        $title = "{$comment->profile->name} commented on {$refrence_phrase}:";
        return (new WebPushMessage)
            ->title($title)
            ->icon($comment->profile->profile_photo_url)
            ->body($comment->content)
            ->action('View comment', 'view_comment')
            ->data(['id' => $notification->id, 'action_url' => ['view_comment' => $post->url->show . "?active_comment={$comment->id}"], 'notifiable' => $notifiable->id])
            ->badge(asset('/icon/logo.png'))
            ->image($comment->gallery->first()?->image_url)
            ->renotify(true)
            ->requireInteraction(true)
            ->tag('comments')
            ->vibrate(config('notifications.push-vibrate-pattern'));
    }
}
