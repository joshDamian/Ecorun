<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Validation\Rule;

trait CreateProfileContent
{
    use UploadPhotos;

    public $profile;
    public $photos = [];
    public $content;
    public $ready;

    public function done()
    {
        $this->ready = null;
        $this->photos = [];
        $this->content = null;
        return $this->resetErrorBag();
    }

    public function ready(): void
    {
        $this->ready = true;
    }

    public function updatedPhotos(): void
    {
        $this->validate([
            'photos.*' => ['image', 'max:5120']
        ]);
    }

    abstract public function create();

    public function defaultContentValidation()
    {
        return
            $this->validate([
                'content' => Rule::requiredIf(count($this->photos) === 0),
                'photos' => Rule::requiredIf(empty(trim($this->content))),
                'photos.*' => ['image', 'max:5120']
            ]);
    }
}
