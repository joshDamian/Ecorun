<?php

namespace App\DataBanks\Profile;

use App\DataBanks\DataBank;
use App\Models\Post;
use App\Models\Product;
use App\Models\Profile;

class FeedDataBank implements DataBank
{
    protected Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile->loadMissing('following.profileable');
    }

    public function fetch()
    {
        $following = $this->profile->following;
        $businesses_following = $following->filter(
            function ($following) {
                return $following->isBusiness();
            }
        );
        $post_relations = collect(['gallery', 'likes', 'comments']);
        $product_relations = collect(['business.profile', 'specifications', 'gallery']);

        return collect([
            Post::class => Post::with($post_relations->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(2592000);
                }];
            })->toArray())->whereIn('profile_id', $following->pluck('id'))->latest()->get()->unique(),

            Product::class =>
            Product::with($product_relations->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(2592000);
                }];
            })->toArray())->whereIn('business_id', $businesses_following->pluck('profileable.id'))->where('is_published', true)->latest()->get()->unique()
        ]);
    }
}
