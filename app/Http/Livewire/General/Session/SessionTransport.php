<?php

namespace App\Http\Livewire\General\Session;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\RecentlyViewed;
use App\Models\Product;

class SessionTransport extends Component
{
    public function mount()
    {
        if (Auth::user()) {
            $this->session_transport('view_history');
            $this->session_transport('guest_cart');
        }
    }

    public function session_transport($key)
    {
        switch ($key) {
            case 'view_history':
                $guest_view_history = session()->get('product_view_history');
                if ($guest_view_history) {
                    foreach ($guest_view_history as $history) {
                        (Auth::user()->view_history->whereIn('product_id', [$history])->count() > 0) ? true  :
                            Product::find($history)->view_history()->save(
                                Auth::user()->view_history()->save(
                                    new RecentlyViewed()
                                )
                            );
                    }
                    session()->forget('product_view_history');
                }
                break;

            case 'guest_cart':
                $guest_cart = session()->get('guest_cart');
                if ($guest_cart) {
                    foreach ($guest_cart  as $cart_item) {
                        $existing = (Auth::user()->cart()->whereIn('product_id', [$cart_item['product_id']])->count() > 0);
                        if (!$existing) {
                            Product::find($cart_item['product_id'])->cart_instances()->save(
                                Auth::user()->cart()->create(
                                    [
                                        'quantity' => $cart_item['quantity'],
                                        'specifications' => (array_key_exists('specifications', $cart_item)) ?
                                            $cart_item['specifications'] : null
                                    ]
                                )
                            );
                        }
                    }
                    session()->forget('guest_cart');
                }
                break;

            default:
                # code...
                break;
        }
    }

    public function render()
    {
        return view('livewire.general.session.session-transport');
    }
}