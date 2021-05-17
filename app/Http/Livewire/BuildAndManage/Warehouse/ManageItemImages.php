<?php

namespace App\Http\Livewire\BuildAndManage\Warehouse;

use Livewire\Component;
use App\Http\Livewire\Traits\UploadPhotos;

class ManageItemImages extends Component
{
    use UploadPhotos;
    public $item;
    public $photos = [];

    protected $rules = [
        'photos.*' => [
            'required', 'image', 'max:10240'
        ],
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function getSellableProperty(): object
    {
        return  $this->item->sellable;
    }

    public function deleteImage($image)
    {
        $image = $this->sellable->gallery->find($image);
        $image->delete();
        $this->sellable->flushQueryCache();
        if ($this->sellable->gallery->count() === 0) {
            $this->sellable->forceFill([
                'is_published' => false
            ])->save();
            $this->sellable->flushQueryCache();
            $this->emitTo("build-and-manage.{$this->sellable->sellable_name->lower()}.{$this->sellable->sellable_name->lower()}-dashboard", 'unpublishedMe');
        }
        return $this->emitSelf('refresh');
    }

    public function saveImages(): void
    {
        $this->validate();
        $this->uploadPhotos(photos: $this->photos, folder: "{$this->sellable->sellable_name->lower()}-photos", imageable: $this->sellable, label: "{$this->sellable->sellable_name->lower()}_image", sizes: array(1600, 1600));
        $this->sellable->flushQueryCache();
        $this->emitSelf('refresh');
        return;
    }

    public function render()
    {
        return view('livewire.build-and-manage.warehouse.manage-item-images', [
            'sellable' => $this->sellable,
            'sellable_name' => $this->sellable->sellable_name
        ]);
    }
}
