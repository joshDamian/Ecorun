<?php

namespace App\Notifications;

use App\Models\Like;
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
        $like_name = strtolower(last(explode('\\', $shareable->getMorphClass())));
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
            ->action("To @{$notifiable->tag}", 'notifiable')
            ->options(['tag' => 'likes', 'topic' => 'likes'])
            ->data(['id' => $notification->id])
            ->badge(asset('/icon/logo.png'))
            // ->dir()
            //->image()
            // ->lang()
            ->renotify()
            ->requireInteraction()
            ->tag('likes')
            ->vibrate(50000);
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
