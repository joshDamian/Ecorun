<?php

namespace App\Queues;

use App\Http\Livewire\Traits\UploadPhotos as Upload;

class UploadPhotos {
    use Upload;

    private array $photos = [];
    private string $label = '';
    private object $imageable;
    private $sizes;
    private string $folder = '';

    public function upload() {
        return $this->uploadPhotos($this->folder, $this->imageable, $this->label, $this->sizes);
    }

    public function prepare($folder, $photos, $label, $imageable, $sizes = null) {
        $this->folder = $folder;
        $this->photos = $photos;
        $this->label = $label;
        $this->imageable = $imageable;
        $this->sizes = $sizes;
        return $this;
    }
}