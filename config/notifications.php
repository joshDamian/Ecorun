<?php

use App\Models\Post;
use App\Models\Product;
use App\Notifications\PostCreated;
use App\Notifications\ProductCreated;
use App\Notifications\MentionedInPost;

return [
    'types' => [
        PostCreated::class => [
            'model' => Post::class,
            'with' => ['profile'],
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
    ]
];