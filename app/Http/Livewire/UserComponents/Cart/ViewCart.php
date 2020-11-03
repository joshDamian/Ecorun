<?php

namespace App\Http\Livewire\UserComponents\Cart;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ViewCart extends Component
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
        return view('livewire.user-components.cart.view-cart', [
            'cart_items' => (Auth::user()) ? Auth::user()->cart()->latest()->paginate(4) : session()->get('guest_cart', [])
        ]);
    }
}
