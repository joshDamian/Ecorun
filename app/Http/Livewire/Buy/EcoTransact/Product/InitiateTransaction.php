<?php

namespace App\Http\Livewire\Buy\EcoTransact\Product;

use App\Models\Buy\Product\Order;
use Livewire\Component;
use App\Models\Build\Sellable\Product\Product;

class InitiateTransaction extends Component
{
    public Product $product;
    public array $selected_specs = [];
    public Order $order;

    public function mount()
    {
        $this->order = new Order();
        foreach ($this->raw_specs as $spec) {
            $this->selected_specs[$spec->singular('name')] = $spec->value[0];
        }
        $this->order->quantity = 1;
    }

    public function getRawSpecsProperty()
    {
        return $this->product->specifications->filter(function ($spec) {
            return $spec->is_specific;
        });
    }

    public function rules()
    {
        return [
            'order.quantity' => ['number', 'required']
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.buy.eco-transact.product.initiate-transaction', [
            'raw_specs' => $this->raw_specs
        ]);
    }
}
