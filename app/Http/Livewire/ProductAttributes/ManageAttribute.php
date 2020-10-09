<?php

namespace App\Http\Livewire\ProductAttributes;

use App\Models\Product;
use App\Models\ProductAttribute;
use Livewire\Component;

class ManageAttribute extends Component
{
    public ProductAttribute $attribute;

    protected $rules = [
        'attribute.name' => [
            'required',
            'min:3'
        ],
        'attribute.value' => 'required'
    ];

    public function edit()
    {
        $this->validate();

        $this->attribute->save();

        $this->emitSelf('saved');
    }

    public function delete()
    {
        $this->attribute->delete();

        $this->emit('modifiedAttributes');
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.product-attributes.manage-attribute');
    }
}
