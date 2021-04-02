<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ProductCreated extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
    * Create a new notification instance.
    *
    * @return void
    */
    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
    * Get the notification's delivery channels.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function via($notifiable) {
        return [
            'mail',
            'database',
            'broadcast',
            WebPushChannel::class
        ];
    }

    public function toWebPush($notifiable, $notification) {
        $product = $this->product;

        $title = "{$product->business->profile->name} added a new product:";
        $message = (new WebPushMessage)
        ->title($title)
        ->icon($product->business->profile->profile_photo_url)
        ->body($product->name)
        ->action("To @{$notifiable->tag}", $notifiable->id)
        //->action('Reply', 'reply')
        ->options(['tag' => 'products', 'topic' => 'products'])
        ->data(['id' => $notification->id])
        ->badge(asset('/icon/logo.png'))
        // ->dir()
        //->image()
        // ->lang()
        ->renotify()
        ->requireInteraction()
        ->tag('products')
        ->vibrate(50000);
        return $message;
    }

    /**
    * Get the mail representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail($notifiable) {
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
    public function toArray($notifiable) {
        return [
            "model_key" => $this->product->id,
            "title" => "New product alert"
        ];
    }
}