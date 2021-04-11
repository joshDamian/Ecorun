<?php

declare(strict_types = 1);

namespace App\Http\Livewire\Traits;

use App\Models\Music;

trait MediaDownload {
    public function downloadMusic(Music $music) {
        $resources_path = $music->audio->url;
        $extension = pathinfo($resources_path, PATHINFO_EXTENSION);
        $filename = "{$music->artiste} - $music->title.{$extension}";
        return \Storage::disk('public')->download($resources_path, $filename);
    }
}