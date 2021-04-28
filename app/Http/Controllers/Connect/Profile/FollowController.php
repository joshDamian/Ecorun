<?php

namespace App\Http\Controllers\Connect\Profile;

use Illuminate\Http\Request;
use App\Models\Connect\Profile\Profile;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function store(Profile $profile, Request $request)
    {
        $this->middleware(['auth:sanctum', 'verified']);
        $user = $request->user()?->loadMissing('currentProfile');
        if ($user) {
            if (!$user->can('update', $profile)) {
                $user->currentProfile->following()->toggle($profile);
                return $user->currentProfile->flushQueryCache();
            }
        }
    }
}
