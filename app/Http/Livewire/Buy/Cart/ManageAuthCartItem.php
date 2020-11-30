<?php

namespace App\Http\Livewire\Buy\Cart;

use App\Models\Cart;
use Livewire\Component;

class ManageAuthCartItem extends Component
{
    public Cart $cart_item;

    protected $rules = [
        'cart_item.quantity' => ['required', 'int', 'min:1'],
    ];

    public function update()
    {
        $this->validate();
        $this->emit('modifiedCart');
    }

    public function messages()
    {
        return [
            'cart_item.quantity.required' => 'quantity is required'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function delete()
    {
        $this->cart_item->delete();

        $this->emit('modifiedCart');
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-auth-cart-item');
    }
}
