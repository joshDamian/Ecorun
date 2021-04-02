<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class MentionedInPost extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public Post $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
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
        $post = $this->post;
        $title = "{$post->profile->name} mentioned you in their post:";
        $message = (new WebPushMessage)
            ->title($title)
            ->icon($post->profile->profile_photo_url)
            ->body($post->content)
            ->action("To @{$notifiable->tag}", 'notifiable')
            ->options(['tag' => 'mentions', 'topic' => 'mentions'])
            ->data(['id' => $notification->id, 'notifiable' => $notifiable->id])
            ->badge(asset('/icon/logo.png'))
            // ->dir()
            //->image()
            // ->lang()
            ->renotify()
            ->requireInteraction()
            ->tag('mentions')
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
            'model_key' => $this->post->id,
            'title' => 'You were mentioned',
        ];
    }
}
