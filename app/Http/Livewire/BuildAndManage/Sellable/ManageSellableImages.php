<?php

namespace App\Http\Livewire\BuildAndManage\Sellable;

use Livewire\Component;
use App\Models\Build\Sellable\Sellable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Livewire\Traits\UploadPhotos;

class ManageSellableImages extends Component
{
    use UploadPhotos;
    public Sellable $sellable;
    public $photos = [];

    protected $rules = [
        'photos.*' => [
            'required', 'image', 'max:10240'
        ],
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function getItemProperty(): object
    {
        return $this->sellable->item;
    }

    public function deleteImage($image)
    {
        $image = $this->item->gallery->find($image);
        Storage::disk('public')->delete($image->image_url);
        $image->delete();
        if ($this->item->gallery->count() === 0) {
            $this->item->forceFill([
                'is_published' => false
            ])->save();
            $this->emitTo("build-and-manage.{$this->sellable_name->lower()}.{$this->sellable_name->lower()}-dashboard", 'unpublishedMe');
        }
        return $this->emitSelf('refresh');
    }

    public function saveImages(): void
    {
        $this->validate();
        $this->uploadPhotos(photos: $this->photos, folder: "{$this->sellable_name->lower()}-photos", imageable: $this->item, label: "{$this->sellable_name->lower()}_image", sizes: array(1600, 1600));
        $this->emitSelf('refresh');
        return;
    }

    public function getSellableNameProperty()
    {
        return Str::of(class_basename($this->item));
    }

    public function render()
    {
        return view('livewire.build-and-manage.sellable.manage-sellable-images', [
            'item' => $this->item,
            'sellable_name' => $this->sellable_name
        ]);
    }
}
