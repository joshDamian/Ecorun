<?php

namespace App\Http\Livewire\BuildAndManage\Service;

use Livewire\Component;
use App\Http\Livewire\Traits\UploadPhotos;
use App\Http\Livewire\Traits\MultipleImageSelector;
use App\Models\Buy\Service\Service;
use App\Models\Build\Sellable\Sellable;
use Illuminate\Validation\Rule;

class CreateNewService extends Component
{
    use UploadPhotos, MultipleImageSelector;

    public $business;
    public $photos = [];
    public $service_created;
    public $service = ['name' => '', 'description' => '', 'price' => 100, 'pricing' => 'fixed'];

    public function rules()
    {
        return [
            'service.name' => ['required', 'string', 'min:4'],
            'service.price' => [Rule::requiredIf($this->service['pricing'] === 'fixed'), 'int', 'min:1'],
            'service.description' => ['required', 'string', 'min:10'],
            'service.pricing' => ['required', 'string', Rule::in(['fixed', 'quotation'])],
            'photos.*' => ['image', 'max:10240'],
            'photos' => ['required']
        ];
    }

    public function create()
    {
        $this->validate();
        $this->service = Service::create([
            'name' => $this->service['name'],
            'description' => $this->service['description'],
            'price' => $this->service['price']
        ]);
        Sellable::forceCreate([
            'vendor_id' => $this->business->id,
            'vendor_type' => $this->business::class,
            'item_id' => $this->service->id,
            'item_type' => $this->service::class
        ]);
        $this->uploadPhotos(photos: $this->photos, folder: 'service-photos', imageable: $this->service, label: 'service_image', sizes: array(1600, 1600));
        $this->service_created = true;
    }

    public function render()
    {
        return view('livewire.build-and-manage.service.create-new-service');
    }
}
