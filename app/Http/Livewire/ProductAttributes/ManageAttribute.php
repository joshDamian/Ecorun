<?php

namespace App\Http\Livewire\ProductAttributes;

use App\Models\ProductAttribute;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManageAttribute extends Component
{
    public ProductAttribute $attribute;

    public $current_name;

    protected $rules = [
        'attribute.name' => [
            'required',
            'min:3',
        ],
        'attribute.value' => 'required',
        'attribute.is_specific' => ''
    ];

    public function edit()
    {
        $this->current_name  = ProductAttribute::find($this->attribute->id)->name;
        $this->validate([
            'attribute.name' => [
                'required',
                'min:3',
                ($this->attribute->name !== $this->current_name) ? Rule::unique('product_attributes', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->attribute->product_id);
                }) : ''
            ],
            'attribute.value' => 'required'
        ]);

        $this->attribute->value = (is_array($this->attribute->value)) ? $this->attribute->value : explode(',', $this->attribute->value);

        $this->attribute->save();

        $this->emitSelf('saved');
    }

    public function delete()
    {
        $this->attribute->delete();

        $this->emit('modifiedAttributes');
    }

    public function updated($propertyName)
    {
        $this->current_name  = ProductAttribute::find($this->attribute->id)->name;
        $this->validateOnly($propertyName, [
            'attribute.name' => [
                'required',
                'min:3',
                ($this->attribute->name !== $this->current_name) ? Rule::unique('product_attributes', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->attribute->product_id);
                }) : null
            ],
            'attribute.value' => 'required'
        ]);
    }

    public function render()
    {
        return view('livewire.product-attributes.manage-attribute');
    }
}
