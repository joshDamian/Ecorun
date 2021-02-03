<?php

namespace App\Http\Livewire\Traits;

trait MultipleImageSelector
{
    public $addedImages = [];
    protected array $image_validation = [
        'bail',
        'mimes:jpeg,bmp,png,svg,webp',
        'file',
        'image',
        'max:10240'
    ];

    public function updatedAddedImages() {
        $this->photos = collect($this->photos)->merge($this->addedImages)->unique()->all();
        return;
    }

    public function updatedPhotos(): void
    {
        $this->filterImages();
        $this->validate([
            'photos.*' => $this->image_validation
        ]);
    }

    public function removeFromPhotos($key) {
        unset($this->photos[(int) $key]);
        return;
    }

    protected function filterImages() {
        collect($this->photos)->each(function($photo, $key) {
            if ($this->validPreviewUrl($photo) === null) {
                $this->removeFromPhotos($key);
            }
        });
        return;
    }

    protected function validPreviewUrl($photo) {
        try {
            return $photo->temporaryUrl();
        } catch (\Throwable $th) {
            return null;
        }
    }
}