<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTransport
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next) {
        if (Auth::check()) {
            $guest_view_history = collect(session()->get('product_view_history', []));
            if ($guest_view_history->count() > 0) {
                $guest_view_history->reject(function($history) {
                    return auth()->user()->view_history()->where('product_id', $history->product_id)->exists();
                })->each(function($history) {
                    $history->user_id = auth()->user()->id;
                    $history->save();
                });
                session()->forget('product_view_history');
            }

            $guest_cart = collect(session()->get('guest_cart', []));
            if ($guest_cart->count() > 0) {
                $guest_cart->reject(function($item) {
                    return auth()->user()->cart()->where('product_id', $item->product_id)->exists();
                })->each(function($item) {
                    $item->user_id = auth()->user()->id;
                    $item->save();
                });

                session()->forget('guest_cart');
            }
        }

        return $next($request);
    }
}