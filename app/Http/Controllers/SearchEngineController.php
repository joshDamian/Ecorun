<?php

namespace App\Http\Controllers;

use App\Engines\SearchEngine;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class SearchEngineController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function show()
    {
        //
    }

    public function search(Request $request, $data)
    {
        App::singleton('search_engine', function () {
            return new SearchEngine;
        });
        dd(app('search_engine')->setQuery($data)->setDataSet($request->input('data-set'))->crawl()->results());
    }
}
