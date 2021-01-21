<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchEngineController extends Controller
{
    public function index(Request $request, $query = null)
    {
        $data_set = $request->input('data-set');
        return view('search.index', compact('data_set', 'query'));
    }
}
