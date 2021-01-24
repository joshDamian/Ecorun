<?php

use App\Models\Post;
use App\Models\Product;
use App\Models\Share;
use App\Notifications\ContentShared;
use App\Notifications\PostCreated;
use App\Notifications\ProductCreated;
use App\Notifications\MentionedInPost;

return [
    'types' => [
        PostCreated::class => [
            'model' => Post::class,
            'with' => ['profile', 'gallery'],
            'count' => ['gallery'],
            'display-card' => 'post-created-display'
        ],
        ProductCreated::class => [
            'model' => Product::class,
            'with' => ['business.profile'],
            'display-card' => 'product-created-display'
        ],
        MentionedInPost::class => [
            'model' => Post::class,
            'with' => ['profile'],
            'display-card' => 'mentioned-in-post-display'
        ],
        ContentShared::class => [
            'model' => Share::class,
            'with' => ['profile', 'shareable'],
            'display-card' => 'content-shared-display'
        ]
    ]
];
