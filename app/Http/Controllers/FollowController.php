<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Profile $profile, Request $request)
    {
        if ($request->user()) {
            if (!$request->user()->can('update', $profile)) {
                $request->user()->following()->toggle($profile);
            }
        }
    }
}
