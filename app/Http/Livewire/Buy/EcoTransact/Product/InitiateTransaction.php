<?php

namespace App\Http\Livewire\Buy\EcoTransact\Product;

use App\Models\Order;
use Livewire\Component;
use App\Models\Build\Sellable\Product\Product;
use Illuminate\Validation\Rule;

class InitiateTransaction extends Component
{
    public Product $product;
    public array $specifications = [];
    public Order $order;

    public function mount()
    {
        $this->order = new Order();
        foreach ($this->product->indicated_specs as $spec) {
            $this->specifications[$spec->singular('name')] = $spec->value[0];
        }
        $this->order->quantity = 1;
    }

    public function rules()
    {
        return [
            'order.quantity' => ['number', Rule::requiredIf($this->product->available_stock)]
        ];
    }

    public function render()
    {
        return view('livewire.buy.eco-transact.product.initiate-transaction', [
            'specifications' => $this->product->specifications->filter(function ($spec) {
                return $spec->is_specific;
            })
        ]);
    }
}
