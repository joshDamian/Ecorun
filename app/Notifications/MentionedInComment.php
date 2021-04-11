<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Feedback;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class MentionedInComment extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $comment;

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

    public function toWebPush($notifiable, $notification)
    {
        $comment = $this->comment;
        $title = "{$comment->profile->name} mentioned you in a comment:";
        $message = (new WebPushMessage)
            ->title($title)
            ->icon($comment->profile->profile_photo_url)
            ->body($comment->content)
            ->action("view comment", 'view_comment')
            ->data(['id' => $notification->id, 'notifiable' => $notifiable->id, 'action_url' => ['view_comment' => $comment?->feedbackable?->url?->show]])
            ->badge(asset('/icon/logo.png'))
            ->image($comment->gallery?->first()?->image_url)
            ->renotify(true)
            ->requireInteraction(true)
            ->tag('mentions')
            ->vibrate(config('notifications.push-vibrate-pattern'));
        return $message;
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
            'title' => 'You were mentioned',
            'model_key' => $this->comment->id
        ];
    }
}
