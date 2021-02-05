<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\Traits\UploadPhotos;
use App\Models\Profile;
use Illuminate\Validation\Rule;

trait CreatesSocialContent
{
    use UploadPhotos;
    use MultipleImageSelector;

    public Profile $profile;
    public string $text_content = '';
    public $photos = [];

    public function done() {
        $this->reset('photos', 'text_content');
        $this->resetErrorBag();
        return;
    }

    public function hintMentions($mention) {
        return \App\Models\Profile::search($mention)->get()->unique()->all();
    }

    public function hintHashtags($hashtag) {
        return \App\Models\Tag::search($hashtag)->get()->pluck('name')->unique()->all();
    }

    abstract public function create();

    public function defaulRules(): array
    {
        return [
            'text_content' => Rule::requiredIf(count($this->photos) < 1),
            'photos' => [
                'array',
                Rule::requiredIf(empty(trim($this->text_content)))
            ],
            'photos.*' => $this->image_validation
        ];
    }
}