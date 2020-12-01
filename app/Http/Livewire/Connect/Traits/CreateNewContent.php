<?php

namespace App\Http\Livewire\Connect\Traits;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

trait CreateNewContent
{
    use WithFileUploads;

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

    public function uploadPhotos(string $folder, object $imageable, string $label, array $sizes = null)
    {
        if (count($this->photos) > 0) {
            foreach ($this->photos as $photo) {
                $photo_path = $photo->store($folder, 'public');
                if ($sizes) {
                    $photo = Image::make(public_path("/storage/{$photo_path}"))->fit($sizes[0], $sizes[1], function ($constraint) {
                        $constraint->upsize();
                    });
                    $photo->save();
                }
                $imageable->gallery()->create([
                    'image_url' => $photo_path,
                    'label' => $label
                ]);
            }
        }
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
