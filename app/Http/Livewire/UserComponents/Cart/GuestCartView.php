<?php

namespace App\Http\Livewire\UserComponents\Cart;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class GuestCartView extends Component
{
    use WithPagination;

    public $cart_items;
    protected $listeners = [
        'modifiedCart' => '$refresh'
    ];

    public function render()
    {
        return view(
            'livewire.user-components.cart.guest-cart-view',
            [
                'products' => Product::whereIn('id', array_keys($this->cart_items))->paginate(4)
            ]
        );
    }
}
