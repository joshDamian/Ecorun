<?php

return [
    'types' => [
        App\Notifications\PostCreated::class => [
            'model' => App\Models\Post::class,
            'with' => ['profile', 'gallery'],
            'count' => ['gallery'],
            'display-card' => 'post-created-display'
        ],
        App\Notifications\ProductCreated::class => [
            'model' => App\Models\Product::class,
            'with' => ['business.profile'],
            'display-card' => 'product-created-display'
        ],
        App\Notifications\MentionedInPost::class => [
            'model' => App\Models\Post::class,
            'with' => ['profile'],
            'display-card' => 'mentioned-in-post-display'
        ],
        App\Notifications\ContentShared::class => [
            'model' => App\Models\Share::class,
            'with' => ['profile', 'shareable'],
            'display-card' => 'content-shared-display'
        ],
        App\Notifications\CommentedOnPostNotification::class => [
            'model' => App\Models\Feedback::class,
            'with' => ['profile', 'feedbackable.profile'],
            'display-card' => 'commented-on-post'
        ],
        App\Notifications\MentionedInComment::class => [
            'model' => App\Models\Feedback::class,
            'with' => ['profile', 'feedbackable.profile'],
            'display-card' => 'mentioned-in-comment'
        ],
        App\Notifications\RepliedToComment::class => [
            'model' => App\Models\Feedback::class,
            'with' => ['profile', 'feedbackable.profile'],
            'display-card' => 'replied-to-comment'
        ],
        App\Notifications\LikedPost::class => [
            'model' => App\Models\Like::class,
            'with' => ['profile', 'likeable.profile'],
            'display-card' => 'liked-post'
        ]
    ]
];
