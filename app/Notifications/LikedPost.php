<?php

namespace App\Notifications;

use App\Models\Connect\ContentFeedback\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class LikedPost extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $like;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
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
        $like = $this->like;
        $likeable = $like->likeable;
        $like_name = strtolower(last(explode('\\', $likeable->getMorphClass())));
        $liketypes = [
            'post' => [
                'message' => ($likeable->profile_id === $notifiable->id) ? 'your post' : ($likeable->profile_id === $like->profile_id ? 'a post' : "{$likeable->profile->name}'s post"),
                'display_text' => $likeable->content
            ],
            'product' => [
                'message' => ($likeable->business->profile->id === $notifiable->id) ? 'your product' : ($likeable->business->profile_id === $like->profile_id ? 'a product' : "{$likeable->business->profile->name}'s product"),
                'display_text' => $likeable->name,
            ]
        ];
        $refrence_phrase = $liketypes[$like_name]['message'];
        $title = "{$like->profile->name} liked {$refrence_phrase}:";
        $message = (new WebPushMessage)
            ->title($title)
            ->icon($like->profile->profile_photo_url)
            ->body($liketypes[$like_name]['display_text'])
            ->action("view {$like_name}", "view_{$like_name}")
            ->data(['id' => $notification->id, 'notifiable' => $notifiable->id, 'action_url' => ["view_{$like_name}" => $likeable?->url?->show]])
            ->badge(asset('/icon/logo.png'))
            ->image($likeable->gallery?->first()?->image_url)
            ->renotify(true)
            ->requireInteraction(true)
            ->tag('likes')
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
            'title' => 'New like alert',
            'model_key' => $this->like->id
        ];
    }
}
