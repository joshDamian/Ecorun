<?php

namespace App\Presenters\Bookmark;

use App\Models\Bookmark;

class UrlPresenter
{
    protected Bookmark $bookmark;

    public function __construct(Bookmark $bookmark) {
        $this->bookmark = $bookmark;
    }

    public function __get($key) {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    private function edit() {
        return route('bookmark.edit', ['profile' => auth()->user()->currentProfile, 'bookmark' => $this->bookmark]);
    }

    private function delete() {
        return route('bookmark.delete', ['profile' => auth()->user()->currentProfile, 'bookmark' => $this->bookmark]);
    }
}