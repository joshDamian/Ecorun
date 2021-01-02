<?php

namespace App\DataBanks;

use App\Models\Post;
use App\Models\Product;
use App\Models\Profile;

class ProfileDataBank
{
    public Profile $profile;
    
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function feed()
    {
        $following = $this->profile->loadMissing('following')->following->loadMissing('profileable');
        $businesses_following = $following->filter(
            function ($following) {
                return $following->isBusiness();
            }
        );

        return collect(
            Post::with(
                [
                    'gallery' => function ($query) {
                        return $query->cacheFor(3600);
                    }, 'likes' => function ($query) {
                        return $query->cacheFor(3600);
                    }, 'comments' => function ($query) {
                        return $query->cacheFor(3600);
                    }, 'profile' => function ($query) {
                        return $query->cacheFor(3600);
                    }
                ]
            )->whereIn('profile_id', $following->pluck('id'))->withCount('gallery')->latest()->get()->unique()->merge(
                Product::with(
                    [
                        'business.profile' => function ($query) {
                            return $query->cacheFor(3600);
                        },
                        'specifications' => function ($query) {
                            return $query->cacheFor(3600);
                        },
                    ]
                )->whereIn('business_id', $businesses_following->pluck('profileable.id'))->where('is_published', true)->latest()->get()->unique()
            )->sortByDesc('created_at')->all()
        );
    }
}
