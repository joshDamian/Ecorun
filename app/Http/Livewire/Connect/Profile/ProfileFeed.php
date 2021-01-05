<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Product;

class ProfileFeed extends Component
{
    public $perPage = 15;
    public $sortBy = 'all';
    public string $viewIncludeFolder = 'includes.feed-display-cards.';
    public $feed_display_cards = [
        Post::class => 'post-display',
        Product::class => 'product-display'
    ];
    public Profile $profile;

    public function getFeedProperty()
    {
        return $this->profile->feed;
    }

    public function getDisplayingFeedProperty()
    {
        return $this->sortFeed($this->sortBy)->sortByDesc('created_at')->take($this->perPage);
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
            case ('gallery'):
                return $this->feed->gallery;
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
