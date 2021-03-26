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
    public $videos = [];
    public $audio;

    public function done()
    {
        $this->reset('photos', 'text_content', 'videos');
        $this->resetErrorBag();
        return;
    }

    public function hintMentions($mention)
    {
        return \App\Models\Profile::search($mention)->get()->unique()->all();
    }

    public function hintHashtags($hashtag)
    {
        return \App\Models\Tag::search($hashtag)->get()->pluck('name')->unique()->all();
    }

    abstract public function create();

    public function validationRules(): array
    {
        return collect([
            'text_content' => Rule::requiredIf((count($this->photos) < 1) && (($this->hasStoredImages) ? $this->gallery->count() < 1 : true)),
            'photos' => [
                'array',
                Rule::requiredIf((empty(trim($this->text_content))) && (($this->hasStoredImages) ? $this->gallery->count() < 1 : true))
            ],
            'photos.*' => $this->image_validation
        ])->merge($this->extra_validation())->toArray();
    }

    abstract public function extra_validation(): array;
}
