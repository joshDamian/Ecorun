<?php

namespace App\Http\Livewire\Buy\Cart;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ViewGuestCartItems extends Component
{
    use WithPagination;

    public $cart_items;
    protected $listeners = [
        'modifiedCart' => '$refresh'
    ];

    public function render()
    {
        return view(
            'livewire.buy.cart.view-guest-cart-items',
            [
                'products' => Product::whereIn('id', array_keys($this->cart_items))->paginate(4)
            ]
        );
    }
}
