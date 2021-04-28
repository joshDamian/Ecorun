<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\PostCreated;
use App\Events\PlacedOrder;
use App\Events\ProductEvents\ProductCreated;
use App\Events\SentMessage;
use App\Events\LikedPost;
use App\Events\ContentShared;
use App\Events\CommentedOnPost;
use App\Events\RepliedToComment;
use App\Events\NewFeedContentForProfile;
use App\Listeners\SendContentSharedNotification;
use App\Listeners\SendPlacedOrderNotification;
use App\Listeners\SendLikedPostNotification;
use App\Listeners\SendRepliedToCommentNotification;
use App\Listeners\SendCommentedOnPostNotification;
use App\Events\NewMessageForProfile;
use App\Listeners\SendPostCreatedNotificaton;
use App\Listeners\SendDirectMessageNotification;
use App\Listeners\SendProductCreatedNotificaton;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostCreated::class => [
            SendPostCreatedNotificaton::class
        ],
        ProductCreated::class => [
            SendProductCreatedNotificaton::class
        ],
        SentMessage::class => [
            SendDirectMessageNotification::class
        ],
        NewMessageForProfile::class => [],
        NewFeedContentForProfile::class => [],
        ContentShared::class => [
            SendContentSharedNotification::class
        ],
        CommentedOnPost::class => [
            SendCommentedOnPostNotification::class
        ],
        RepliedToComment::class => [
            SendRepliedToCommentNotification::class,
        ],
        LikedPost::class => [
            SendLikedPostNotification::class
        ],
        PlacedOrder::class => [
            SendPlacedOrderNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
