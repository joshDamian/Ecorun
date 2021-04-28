<?php

namespace App\Http\Controllers\Information\User;

use App\Models\Information\User\RecentlyViewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Build\Sellable\Product\Product;
use App\Http\Controllers\Controller;

class RecentlyViewedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* if (Auth::user()) {
            $product_history_log = Auth::user()->view_history()->paginate(8);
        } else {
            $product_history_log = Product::whereIn('id', session()->get('user_product_view_history', []))->latest()->paginate(8);
        }
 */
        return view('view-history.index', compact('product_history_log'));
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
     * @param  \App\Models\RecentlyViewed  $recentlyViewed
     * @return \Illuminate\Http\Response
     */
    public function show(RecentlyViewed $recentlyViewed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecentlyViewed  $recentlyViewed
     * @return \Illuminate\Http\Response
     */
    public function edit(RecentlyViewed $recentlyViewed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecentlyViewed  $recentlyViewed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecentlyViewed $recentlyViewed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecentlyViewed  $recentlyViewed
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecentlyViewed $recentlyViewed)
    {
        //
    }
}
