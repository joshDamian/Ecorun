<?php

namespace App\Http\Livewire\Traits;

use App\Models\Profile;
use App\Models\Bookmark;

trait HasBookmarks {
    public Profile $profile;
    public $bookmarkable;
    public $bookmarked;
    public string $title = '';

    public function bookmark() {
        if ($this->bookmarked()) {
            $this->profile->bookmarks()->where('bookmarkable_id', $this->bookmarkable->id)->where('bookmarkable_type', get_class($this->bookmarkable))->delete();
            $this->profile->flushQueryCache();
            $this->bookmarked = false;
        } else {
            $bookmarkable_type = get_class($this->bookmarkable);

            $bookmark = Bookmark::forceCreate([
                'bookmarkable_type' => $bookmarkable_type,
                'bookmarkable_id' => $this->bookmarkable->id,
                'profile_id' => $this->profile->id,
                'title' => (empty($this->title)) ? ('Bookmark') : $this->title
            ]);
            $this->bookmarked = true;
        }
        return $this->emit('modifiedBookmarks');
    }

    public function bookmarked() {
        return $this->profile->bookmarks()->where('bookmarkable_id', $this->bookmarkable->id)->where('bookmarkable_type', get_class($this->bookmarkable))->exists();
    }
}