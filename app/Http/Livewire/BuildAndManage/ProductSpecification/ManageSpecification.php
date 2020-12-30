<?php

namespace App\Http\Livewire\BuildAndManage\ProductSpecification;

use App\Models\ProductSpecification;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ManageSpecification extends Component
{
    public ProductSpecification $specification;

    public $current_name;

    protected $rules = [
        'specification.name' => [
            'required',
            'min:3',
        ],
        'specification.value' => 'required',
        'specification.is_specific' => ''
    ];

    public function edit()
    {
        $this->current_name  = ProductSpecification::find($this->specification->id)->name;
        $this->validate([
            'specification.name' => [
                'required',
                'min:3',
                ($this->specification->name !== $this->current_name) ? Rule::unique('product_specifications', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->specification->product_id);
                }) : ''
            ],
            'specification.value' => 'required'
        ]);

        $this->specification->value = (is_array($this->specification->value)) ? $this->specification->value : explode(',', $this->specification->value);

        $this->specification->save();

        $this->emitSelf('saved');
    }

    public function delete()
    {
        $this->specification->delete();

        $this->emit('modifiedSpecifications');
    }

    public function updated($propertyName)
    {
        $this->current_name  = ProductSpecification::find($this->specification->id)->name;
        $this->validateOnly($propertyName, [
            'specification.name' => [
                'required',
                'min:3',
                ($this->specification->name !== $this->current_name) ? Rule::unique('product_specifications', 'name')->where(function ($query) {
                    return $query->where('product_id', $this->specification->product_id);
                }) : null
            ],
            'specification.value' => 'required'
        ]);
    }

    public function render()
    {
        return view('livewire.build-and-manage.product-specification.manage-specification');
    }
}
