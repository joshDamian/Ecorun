<?php

namespace App\Http\Livewire\Buy\Cart;

use Livewire\Component;

class ManageGuestCartItem extends Component
{
    public $cart_item;
    protected $rules = [
        'cart_item.quantity' => ['required', 'int', 'min:1']
    ];

    public function update()
    {
        $this->validate();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        $this->emitSelf('updated');
    }

    public function delete()
    {
        session()->forget("guest_cart.{$this->cart_item['product_id']}");

        return $this->emit('modifiedCart');
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-guest-cart-item');
    }
}
