<?php

namespace App\Http\Livewire\Traits;

use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

trait UploadPhotos
{
    use WithFileUploads;

    public function uploadPhotos(string $folder, object $imageable, string $label, array $sizes = null) {
        if (count($this->photos) > 0) {
            foreach ($this->photos as $photo) {
                $photo_path = $photo->store($folder, 'public');
                ImageOptimizer::optimize(public_path("/storage/{$photo_path}"));
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
            return $this->photos = [];
        }
    }
}