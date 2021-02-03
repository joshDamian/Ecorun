<?php

namespace App\Http\Livewire\Traits;

trait MultipleImageSelector
{
    public $addedImages = [];
    protected array $image_validation =  [
        'bail',
        'mimes:jpeg,bmp,png,svg,webp',
        'file',
        'image',
        'max:10240'
    ];

    public function updatedAddedImages()
    {
        $this->photos = collect($this->photos)->merge($this->addedImages)->all();
        return;
    }

    public function removeFromPhotos($key)
    {
        unset($this->photos[(int) $key]);
        return;
    }

    public function validPreviewUrl($photo, $key)
    {
        try {
            return $photo->temporaryUrl();
        } catch (\Throwable $th) {
            $this->removeFromPhotos($key);
            return null;
        }
    }
}
