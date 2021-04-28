<?php

namespace App\Http\Livewire\Connect\Bookmark;

use Livewire\Component;
use App\Models\Connect\Content\Bookmark;
use Livewire\WithPagination;

class ManageBookmarks extends Component
{
    use WithPagination;

    public $confirm = false;
    public $toBeDeleted;
    public $bookmark_types = [
        'App\Models\Connect\Content\Post' => 'includes.feed-display-cards.post-display',
        'App\Models\Build\Sellable\Product\Product' => 'includes.feed-display-cards.product-display',
    ];
    protected $listeners = [
        'modifiedBookmarks' => '$refresh'
    ];

    public function delete()
    {
        $this->toBeDeleted->delete();
        $this->reset('toBeDeleted', 'confirm');
        return $this->emitSelf('modifiedBookmarks');
    }

    public function confirmDelete($bookmark)
    {
        $this->confirm = true;
        $this->toBeDeleted = $this->bookmarks->find($bookmark);
        return;
    }

    public function getBookmarksProperty()
    {
        return auth()->user()->currentProfile->bookmarks()->with('bookmarkable')->latest()->paginate(15);
    }

    public function cancel()
    {
        return $this->reset('toBeDeleted', 'confirm');
    }

    public function render()
    {
        return view('livewire.connect.bookmark.manage-bookmarks', [
            'bookmarks' => $this->bookmarks
        ]);
    }
}
