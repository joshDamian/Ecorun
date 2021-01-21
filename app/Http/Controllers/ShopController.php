<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with([
            'gallery' => function ($query) {
                return $query->cacheFor(now()->addDays(30));
            }
        ])->latest()->paginate(12);
        return view('shop.index', compact('products'));
    }
}
