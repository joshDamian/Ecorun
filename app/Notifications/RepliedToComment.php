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

class RepliedToComment extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Feedback $reply)
    {
        $this->reply = $reply;
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

    public function toWebPush($notifiable, $notification)
    {
        $reply = $this->reply;
        $replyable = $reply->feedbackable;

        $refrence_phrase = match ($replyable->profile_id === $notifiable->id) {
            true => "your comment",
            false => "a comment"
        };

        $title = "{$reply->profile->name} replied to {$refrence_phrase}:";
        $message = (new WebPushMessage)
            ->title($title)
            ->icon($reply->profile->profile_photo_url)
            ->body($reply->content)
            ->action("view reply", 'view_reply')
            ->data(['id' => $notification->id, 'notifiable' => $notifiable->id, 'action_url' => ['view_reply' => $replyable?->url?->show . "?active_comment={$reply->id}"]])
            ->badge(asset('/icon/logo.png'))
            ->image($reply->gallery?->first()?->image_url)
            ->renotify(true)
            ->requireInteraction(true)
            ->tag('replies')
            ->vibrate(config('notifications.push-vibrate-pattern'));
        return $message;
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
            'model_key' => $this->reply->id
        ];
    }
}
