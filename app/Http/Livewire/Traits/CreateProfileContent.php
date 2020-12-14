<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Validation\Rule;

trait CreateProfileContent
{
    use UploadPhotos;

    public $profile;
    public $photos = [];
    public $content;

    public function done() {
        $this->photos = [];
        $this->content = null;
        $this->resetErrorBag();
        return;
    }

    public function updatedPhotos(): void
    {
        $this->validate([
            'photos.*' => ['image', 'max:5120']
        ]);
    }

    abstract public function create();

    public function defaultContentValidation() {
        return
        $this->validate([
            'content' => Rule::requiredIf(count($this->photos) === 0),
            'photos' => Rule::requiredIf(empty(trim($this->content))),
            'photos.*' => ['image', 'max:5120']
        ]);
    }
}