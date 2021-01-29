<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\Traits\UploadPhotos;
use App\Models\Profile;
use Illuminate\Validation\Rule;

trait CreatesSocialContent
{
    use UploadPhotos;

    public Profile $profile;
    public $mentions;
    public $hashtags;
    public $text_content;
    public $photos = [];

    public function done()
    {
        $this->reset('photos', 'text_content');
        $this->resetErrorBag();
        return;
    }

    public function updatedPhotos(): void
    {
        $this->validate([
            'photos.*' => ['image', 'max:10240']
        ]);
    }

    public function hintMentions($mention)
    {
        $mention = trim($mention, "@");
        return $this->mentions = \App\Models\Profile::search($mention)->get()->toJson();
    }

    public function hintHashtags($hashtag)
    {
        $hashtag = trim($hashtag, "#");
        return $this->hashtags = dump(\App\Models\Tag::search($hashtag)->get()->toJson());
    }

    abstract public function create();

    public function defaulRules(): array
    {
        return [
            'text_content' => Rule::requiredIf(count($this->photos) < 1),
            'photos' => ['array', Rule::requiredIf(empty(trim($this->text_content)))],
            'photos.*' => ['image', 'max:10240']
        ];
    }
}
