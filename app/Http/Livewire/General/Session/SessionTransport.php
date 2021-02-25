<?php

namespace App\Http\Livewire\General\Session;

use Livewire\Component;
use App\Models\RecentlyViewed;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SessionTransport extends Component
{
    public function mount() {
        if (Auth::check()) {
            $this->session_transport('view_history');
            $this->session_transport('guest_cart');
        }
    }

    public function session_transport($key) {
        switch ($key) {
            case 'view_history':
                $guest_view_history = collect(session()->get('product_view_history', []));
                if ($guest_view_history->count() > 0) {
                    $guest_view_history->reject(function($history) {
                        return auth()->user()->view_history()->where('product_id', $history->product_id)->exists();
                    })->each(function($history) {
                        $history->user_id = auth()->user()->id;
                        $history->save();
                    });
                    return session()->forget('product_view_history');
                }
                break;

            case 'guest_cart':
                $guest_cart = collect(session()->get('guest_cart', []));
                if ($guest_cart->count() > 0) {
                    $guest_cart->reject(function($item) {
                        return auth()->user()->cart()->where('product_id', $item->product_id)->exists();
                    })->each(function($item) {
                        $item->user_id = auth()->user()->id;
                        $item->save();
                    });

                    return session()->forget('guest_cart');
                }
                break;

            default:
                // code...
                break;
        }
        return;
    }

    public function render() {
        return view('livewire.general.session.session-transport');
    }
}