<?php

namespace App\Notifications;

use App\Models\Connect\Content\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PostCreated extends Notification implements ShouldBroadcastNow
{
    use Queueable;

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
     * @param  mixed $notifiable
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
        $post = $this->post;
        $gallery = $post->gallery;
        $gallery_count = $gallery->count();
        $refrence_phrase = $gallery_count > 0 ? ($gallery_count > 1 ? "{$gallery_count} new photos" : "{$gallery_count} new photo") : ($post->hasAttachedMusic() ? 'new music' : 'a new post');
        $title = "{$post->profile->name} added {$refrence_phrase}:";
        $message = (new WebPushMessage)
            ->title($title)
            ->icon($post->profile->profile_photo_url)
            ->body((!empty($post->content) ? $post->content : ($post->hasAttachedMusic() ? $post->attachments->music->first()->title . ' - ' . $post->attachments->music->first()->artiste : $refrence_phrase)))
            ->action('view post', 'view_post')
            ->data(['id' => $notification->id, 'notifiable' => $notifiable->id, 'action_url' => ['view_post' => $post->url->show]])
            ->badge(asset('/icon/logo.png'))
            ->renotify(true)
            ->requireInteraction(true)
            ->tag('posts')
            ->image(asset("/storage/{$gallery->first()?->image_url}"))
            ->vibrate(config('notifications.push-vibrate-pattern'));
        return $message;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
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
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'model_key' => $this->post->id,
            'title' => 'New post for you.'
        ];
    }
}
