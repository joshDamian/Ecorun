<?php

namespace App\Notifications;

use App\Models\Share;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ContentShared extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Share $share)
    {
        $this->share = $share;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database', WebPushChannel::class];
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
        $share = $this->share;
        $shareable = $share->shareable;
        $share_name = strtolower(last(explode('\\', $shareable->getMorphClass())));
        $sharetypes = [
            'post' => [
                'message' => ($shareable->profile_id === $notifiable->id) ? 'your post' : ($shareable->profile_id === $share->profile_id ? 'a post' : "{$shareable->profile->name}'s post"),
                'display_text' => $shareable->content
            ],
            'product' => [
                'message' => ($shareable->business->profile->id === $notifiable->id) ? 'your product' : ($shareable->business->profile_id === $share->profile_id ? 'a product' : "{$shareable->business->profile->name}'s product"),
                'display_text' => $shareable->name,
            ]
        ];
        $refrence_phrase = $sharetypes[$share_name]['message'];
        $title = "{$share->profile->name} shared {$refrence_phrase}:";
        $message = (new WebPushMessage)
            ->title($title)
            ->icon($share->profile->profile_photo_url)
            ->body($sharetypes[$share_name]['display_text'])
            ->action("To @{$notifiable->tag}", 'notifiable')
            //->action('Reply', 'reply')
            ->options(['tag' => 'feed content', 'topic' => 'feed content'])
            ->data(['id' => $notification->id])
            ->badge(asset('/icon/logo.png'))
            // ->dir()
            //->image()
            // ->lang()
            ->renotify()
            ->requireInteraction()
            ->tag('feed content')
            ->vibrate(50000);
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
            'model_key' => $this->share->id,
            'title' => 'New feed content'
        ];
    }
}
