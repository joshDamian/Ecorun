<?php

namespace App\Http\Controllers\Build\Sellable\Product;

use App\Models\Build\Sellable\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Build\Sellable\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Product $product, Request $request)
    {
        if ($slug === $product->data_slug('name')) {
            $product->bootstrap();
            return view('products.show', compact('product'));
        }
        return redirect($product->url->show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Build\Sellable\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Build\Sellable\Product\Product      $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Build\Sellable\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
