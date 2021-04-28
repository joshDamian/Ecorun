<?php

namespace App\Presenters\Bookmark;

use App\Models\Connect\Content\Bookmark;
use App\Presenters\Presenter;

class UrlPresenter
{
    use Presenter;
    protected Bookmark $bookmark;

    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    private function edit()
    {
        return route('bookmark.edit', ['profile' => auth()->user()->currentProfile, 'bookmark' => $this->bookmark]);
    }

    private function delete()
    {
        return route('bookmark.delete', ['profile' => auth()->user()->currentProfile, 'bookmark' => $this->bookmark]);
    }
}
