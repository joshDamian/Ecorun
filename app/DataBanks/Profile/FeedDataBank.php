<?php

namespace App\DataBanks\Profile;

use App\DataBanks\DataBank;
use App\Models\Post;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Share;

class FeedDataBank implements DataBank
{
    protected Profile $profile;

    public function __construct(Profile $profile) {
        $this->profile = $profile->loadMissing('following');
    }

    public function fetch() {
        $profile_sources = $this->profile->following->concat([$this->profile]);
        $business_sources = $profile_sources->filter(
            function ($profile) {
                return $profile->isBusiness();
            }
        );
        $post_relations = collect(['gallery', 'likes.profile', 'comments']);
        $product_relations = collect(['business.profile', 'specifications', 'gallery']);
        $share_relations = collect(['shareable', 'profile']);

        return collect([
            Post::class => Post::with($post_relations->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(2592000);
                }];
            })->toArray())->whereIn('profile_id', $profile_sources->pluck('id'))->orWhereJsonContains('mentions', $profile_sources->pluck('id'))->orWhereNotIn('profile_id', $profile_sources->pluck('id'))->distinct()->latest('updated_at')->get()->unique(),

            Product::class =>
            Product::with($product_relations->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(2592000);
                }];
            })->toArray())->whereIn('business_id', $business_sources->pluck('profileable_id'))->distinct()->latest()->get()->unique(),

            Share::class => Share::with($share_relations->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(2592000);
                }];
            })->toArray())->whereIn('profile_id', $profile_sources->pluck('id'))->distinct()->latest('updated_at')->get()->unique(),

            Profile::class => Profile::whereNotIn('id', $profile_sources->pluck('id'))->distinct()->latest('updated_at')->get()->unique(),
        ]);
    }
}