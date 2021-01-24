<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use App\Models\Share;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Product;

class ProfileFeed extends Component
{
    public $perPage = 10;
    public $display_ready = false;
    public string $viewIncludeFolder = 'includes.feed-display-cards.';
    public $feed_types = [
        Post::class => [
            'view' => 'post-display',
            'name' => 'posts'
        ],
        Product::class => [
            'view' => 'product-display',
            'name' => 'products'
        ],
        Share::class => [
            'view' => 'share-display',
            'name' => 'shares'
        ]
    ];

    public Profile $profile;

    public function setDisplayReady()
    {
        return $this->display_ready = true;
    }

    public function getListeners()
    {
        return [
            'sharedContent' => '$refresh',
        ];
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }

    public function getFeedProperty()
    {
        return $this->profile->feed;
    }

    public function getDisplayingFeedProperty()
    {
        if ($this->display_ready) {
            return $this->all_from_sort_by->take($this->perPage);
        }
        return collect([]);
    }

    public function getAllFromSortByProperty()
    {
        return $this->sortFeed($this->sortBy)->sortByDesc('created_at');
    }

    public function all_count()
    {
        return $this->all_from_sort_by->count();
    }

    public function setSortBy(string $sortBy)
    {
        $this->reset('perPage');
        return cache()->put($this->profile->id . "sort_feed_by", $sortBy);
    }

    public function getSortByProperty()
    {
        return cache()->rememberForever($this->profile->id . "sort_feed_by", function () {
            return 'all';
        });
    }

    public function sortFeed($key)
    {
        switch ($key) {
            case ('posts'):
                return $this->feed->posts;
                break;
            case ('products'):
                return $this->feed->products;
                break;
            case ('photos'):
                return $this->feed->photos;
                break;
            case ('mentions'):
                return $this->feed->mentions;
                break;
            case ('shares'):
                return $this->feed->shares;
                break;
            case ('all'):
            default:
                return $this->feed->all;
                break;
        }
    }

    public function render()
    {
        return view('livewire.connect.profile.profile-feed');
    }
}
