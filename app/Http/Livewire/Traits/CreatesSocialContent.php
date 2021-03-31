<?php

namespace App\Http\Livewire\Traits;

use App\Http\Livewire\Traits\UploadPhotos;
use App\Models\Profile;
use App\Models\Music;
use App\Models\Audio;
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
    public $music = [
        'title' => null, 'file' => null, 'artiste' => null,
        'eco_artist' => null, 'cover_art' => null,
        'lyrics' => null, 'associated_acts' => null
    ];

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

    public function broadcast($event, $model)
    {
        try {
            broadcast(new $event($model))->toOthers();
        } catch (\Throwable $th) {
            report($th);
        }
        return $this;
    }

    public function uploadMusic(object $attachable)
    {
        if ($this->music['file'] !== null) {
            $music = (new Music())->forceFill([
                'title' => $this->music['title'],
                'artiste' => $this->music['artiste'],
                'attachable_type' => $attachable->getMorphClass(),
                'attachable_id' => $attachable->id,
                'lyrics' => $this->music['lyrics'] ?? '',
                'cover_art' => $this->uploadPhotos(photos: [$this->music['cover_art']], folder: 'music_cover_art', imageable: null, label: 'cover_art', sizes: [1200, 1200])[0],
                'eco_artist' => $this->music['eco_artist'],
                'associated_acts' => $this->music['associated_acts']
            ]);
            $music->save();
            $this->uploadAudio($music);
        }
        return $this;
    }

    public function uploadAudio($attachable)
    {
        if ($this->audio !== null && in_array(mime_content_type($this->audio->name), ['wav', 'm4a', 'mp3'])) {
            (new Audio())->forceFill([
                'url' => $this->audio->store('audio_files', 'public'),
                'attachable_id' => $attachable->id,
                'attachable_type' => $attachable->getMorphClass()
            ])->save();
        }
        return $this;
    }

    abstract public function create();

    public function validationRules(): array
    {
        return collect([
            'text_content' => Rule::requiredIf($this->emptyContent()),
            'photos' => [
                'array',
                Rule::requiredIf($this->emptyContent())
            ],
            'photos.*' => $this->image_validation,
            'music.file' => [
                'mimes:wav,mp3,m4a',
                'max:30720',
                Rule::requiredIf($this->emptyContent() || $this->activeMusicSelection())
            ],
            'music.title' => [
                'string',
                Rule::requiredIf($this->activeMusicSelection())
            ],
            'music.artiste' => [
                Rule::requiredIf($this->activeMusicSelection()),
                'string'
            ],
            'music.cover_art' => [
                'image',
                'max:10240'
            ]
        ])->merge($this->extra_validation())->toArray();
    }

    public function activeMusicSelection()
    {
        return collect($this->music)->filter()->isNotEmpty();
    }

    public function emptyContent()
    {
        return (empty(trim($this->text_content)) && (($this->hasStoredImages) ? $this->gallery->count() < 1 : true) && (count($this->photos) < 1) && (is_null($this->music['file'])));
    }

    abstract public function extra_validation(): array;
}
