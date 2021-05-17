<?php

namespace App\Http\Controllers\Buy\Product;

use App\Models\Buy\Product\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buy\Product\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buy\Product\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buy\Product\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    public function preview_order(Request $request)
    {
        $cart = $request->user()->cart()->with('product.gallery')->latest('updated_at')->get();
        return view('order.preview_order', compact('cart'));
    }

    public function place_order(Request $request)
    {
        //dd($request->user()->orders->last()->products->first()->orderRequest->status);
        $cartItems = $request->user()->cart()->without('product.gallery')->with('product.business.profile')->get();
        if ($cartItems->count() < 1) {
            return redirect(route('cart.index'));
        }
        $order = $request->user()->orders()->create([
            'status' => 'pending'
        ]);
        $cartItems->each(function ($item) use ($order) {
            $order->products()->attach($item->product_id, [
                'specifications' => json_encode($item->specifications),
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
            $item->delete();
        });
        return view('order.success_page', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buy\Product\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
