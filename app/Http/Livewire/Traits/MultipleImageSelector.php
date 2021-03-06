<?php

namespace App\Http\Livewire\Traits;

trait MultipleImageSelector
{
    public $addedImages = [];
    public bool $hasStoredImages = false;
    protected array $image_validation = [
        'bail',
        'file',
        'image',
        'max:10240'
    ];

    public function updatedAddedImages()
    {
        foreach ($this->addedImages as $image) {
            $this->photos[] = $image;
        }
        return;
    }

    public function updatedPhotos(): void
    {
        $this->filterImages();
        $this->validate([
            'photos.*' => $this->image_validation
        ]);
    }

    public function removeFromPhotos($key)
    {
        unset($this->photos[(int) $key]);
        return;
    }

    protected function filterImages()
    {
        collect($this->photos)->each(function ($photo, $key) {
            if ($this->validPreviewUrl($photo) === null) {
                $this->removeFromPhotos($key);
            }
        });
        return;
    }

    protected function validPreviewUrl($photo)
    {
        if ($photo) {
            try {
                return $photo->temporaryUrl();
            } catch (\Throwable $th) {
                return null;
            }
        }
        return null;
    }
}
