<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Product;

class ProfileFeed extends Component
{
    public $perPage = 5;
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
        ]
    ];
    protected $listeners = [
        'newPost' => '$refresh',
    ];
    public Profile $profile;

    public function setDisplayReady() {
        return $this->display_ready = true;
    }

    public function getFeedProperty() {
        return $this->profile->feed;
    }

    public function getDisplayingFeedProperty() {
        if ($this->display_ready) {
            return $this->sortFeed($this->sortBy)->sortByDesc('created_at')->take($this->perPage);
        }
        return collect([]);
    }

    public function loadMore() {
        return $this->perPage = $this->perPage + 5;
    }

    public function setSortBy(string $sortBy) {
        return cache()->put($this->profile->id . "sort_feed_by", $sortBy);
    }

    public function getSortByProperty() {
        return cache()->remember($this->profile->id . "sort_feed_by", now()->addDays(60), function () {
            return 'all';
        });
    }

    public function sortFeed($key) {
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
            case ('all'):
                default:
                    return $this->feed->all;
                    break;
        }
    }

    public function render() {
        return view('livewire.connect.profile.profile-feed');
    }
}