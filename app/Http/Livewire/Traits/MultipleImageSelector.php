<?php

namespace App\Http\Livewire\Traits;

trait MultipleImageSelector {
    public $addedImages = [];

    public function updatedAddedImages() {
        $this->photos = collect($this->photos)->merge($this->addedImages)->toArray();
        return;
    }

    public function removeFromPhotos($key) {
        unset($this->photos[(int) $key]);
        /* $this->photos = collect($this->photos)->reject(function($photo, $array_key) use($key) {
            return $array_key === ((int) $key);
        })->all(); */
        //dump($this->photos);
    }
}