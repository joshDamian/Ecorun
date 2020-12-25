<?php

use App\Models\Profile;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel(
    'App.Models.User.{id}',
    function ($user, $id):bool {
        return (int) $user->id === (int) $id;
    }
);

Broadcast::channel(
    'App.Models.Profile.{profile}',
    function ($user, Profile $profile):bool {
        return $user->associatedProfiles()->contains($profile) || ($user->load('profile')->profile->id === $profile->id);
    }
);
