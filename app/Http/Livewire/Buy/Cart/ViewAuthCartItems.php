<?php

namespace App\Http\Livewire\Buy\Cart;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAuthCartItems extends Component
{
    use WithPagination;
    public $expanded;

    protected $listeners = [
        'expand_cart',
        'modifiedCart' => '$refresh',
    ];

    public function expand_cart()
    {
        return $this->expanded = true;
    }

    public function count()
    {
        return (Auth::user()) ? Auth::user()->cart->count() : count(session()->get('guest_cart', []));
    }

    public function render()
    {
        return view('livewire.buy.cart.view-auth-cart-items', [
            'cart_items' => (Auth::user()) ? Auth::user()->cart()->latest()->paginate(4) : session()->get('guest_cart', [])
        ]);
    }
}
