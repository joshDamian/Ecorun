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
        $user = $request->user()->loadMissing('currentProfile');
        if ($user) {
            if (!$user->can('update', $profile)) {
                $user->currentProfile->following()->toggle($profile);
                return $user->currentProfile->update();
            }
        }
    }
}
