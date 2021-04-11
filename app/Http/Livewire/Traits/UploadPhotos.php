<?php

declare(strict_types=1);

namespace App\Http\Livewire\Traits;

use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

trait UploadPhotos
{
    use WithFileUploads;

    public function uploadPhotos(array $photos, string $folder, ?object $imageable, string $label, ?array $sizes)
    {
        $photo_paths = [];
        if (collect($photos)->filter()->count() > 0) {
            foreach ($photos as $photo) {
                $photo_path = $photo->store($folder, 'public');
                $this->optimize($photo_path);
                if ($sizes) {
                    $this->resize(sizes: $sizes, photo_path: $photo_path);
                }
                if (is_object($imageable)) {
                    $this->attachImageable(imageable: $imageable, photo_path: $photo_path, label: $label);
                }
                $photo_paths[] = $photo_path;
            }
            $this->photos = [];
        }
        return $photo_paths;
    }

    public function attachImageable($imageable, $label, $photo_path)
    {
        return $imageable->gallery()->create([
            'image_url' => $photo_path,
            'label' => $label
        ]);
    }

    public function resize(array $sizes, string $photo_path)
    {
        $photo = Image::make(public_path("/storage/{$photo_path}"))->fit($sizes[0], $sizes[1], function ($constraint) {
            $constraint->upsize();
        });
        $photo->save();
        return true;
    }

    public function optimize($photo_path)
    {
        return ImageOptimizer::optimize(public_path("/storage/{$photo_path}"));
    }
}
