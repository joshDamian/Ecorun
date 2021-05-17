<?php

namespace App\Http\Livewire\BuildAndManage\Service;

use App\Models\Buy\Service\Service;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditService extends Component
{
    public Service $service;
    public function rules()
    {
        return [
            'service.name' => ['required', 'min:4', 'string'],
            'service.description' => ['required', 'min:20'],
            'service.price' => [Rule::requiredIf($this->service->pricing === 'fixed')]
        ];
    }

    public function save()
    {
        $this->validate();
        $this->service->save();
        $this->emitSelf('saved');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.build-and-manage.service.edit-service', [
            'pricing_map' => ['fixed' => 'fixed pricing', 'quotation' => 'based on quotation']
        ]);
    }
}
